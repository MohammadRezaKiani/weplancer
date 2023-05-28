<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\File;

class ShopLink extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shop:link';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Link theme assets and storage';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $links = config('filesystems.links');
        $themeLinks = config('front.links');

        if (is_array($themeLinks)) {
            $links = array_merge($links, $themeLinks);
        }

        foreach ($links as $link => $target) {
            $this->createLinkOrCopy($target, $link);
        }

        if (is_array($themeLinks)) {
            foreach ($themeLinks as $link => $target) {
                $this->createLinkOrCopy($target, $link);
            }
        }

        $this->line("Linked successfully.\n");

        return 0;
    }

    protected function createLinkOrCopy($target, $link)
    {
        try {
            if (File::exists($link) && !is_link($link)) {
                // If the link already exists but is not a symbolic link, delete it
                File::delete($link);
            }

            if (!File::exists($link)) {
                // Create the link or copy the directory
                if (function_exists('symlink')) {
                    symlink($target, $link);
                } else {
                    File::copyDirectory($target, $link);
                }
            }
        } catch (Exception $e) {
            $this->fallbackLinkOrCopy($target, $link);
        }
    }

    protected function fallbackLinkOrCopy($target, $link)
    {
        try {
            $schedule = new Schedule();
            $command = $this->isWindows() ? 'mklink' : 'ln -s';
            $event = $schedule->exec($command . ' ' . escapeshellarg($target) . ' ' . escapeshellarg($link));
            $event->run($this->laravel);
        } catch (Exception $e) {
            //
        }
    }

    protected function isWindows(): bool
    {
        return strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
    }
}
