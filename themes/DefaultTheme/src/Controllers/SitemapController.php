<?php

namespace Themes\DefaultTheme\src\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Post;
use App\Models\Product;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url as SitemapUrl;

class SitemapController extends Controller
{
    public function index()
    {
        $sitemap = Sitemap::create();

        $sitemap->add(SitemapUrl::create(url('/'))
            ->setPriority(1.0)
            ->setChangeFrequency(SitemapUrl::CHANGE_FREQUENCY_DAILY));

        $sitemap->add(SitemapUrl::create(url('/sitemap-posts'))
            ->setPriority(0.8)
            ->setChangeFrequency(SitemapUrl::CHANGE_FREQUENCY_DAILY));

        $sitemap->add(SitemapUrl::create(url('/sitemap-pages'))
            ->setPriority(0.8)
            ->setChangeFrequency(SitemapUrl::CHANGE_FREQUENCY_DAILY));

        $sitemap->add(SitemapUrl::create(url('/sitemap-products'))
            ->setPriority(0.8)
            ->setChangeFrequency(SitemapUrl::CHANGE_FREQUENCY_DAILY));

        return $sitemap->writeToFile(public_path('sitemap.xml'));
    }

    public function posts()
    {
        $sitemap = Sitemap::create();

        $posts = Post::published()->latest('updated_at')->get();

        foreach ($posts as $post) {
            $sitemap->add(SitemapUrl::create(route('front.posts.show', ['post' => $post]))
                ->setLastModificationDate($post->updated_at)
                ->setPriority(0.8)
                ->setChangeFrequency(SitemapUrl::CHANGE_FREQUENCY_WEEKLY));
        }

        return $sitemap->writeToFile(public_path('sitemap-posts.xml'));
    }

    public function pages()
    {
        $sitemap = Sitemap::create();

        $pages = Page::where('published', true)->latest('updated_at')->get();

        foreach ($pages as $page) {
            $sitemap->add(SitemapUrl::create(route('front.pages.show', ['page' => $page]))
                ->setLastModificationDate($page->updated_at)
                ->setPriority(0.8)
                ->setChangeFrequency(SitemapUrl::CHANGE_FREQUENCY_WEEKLY));
        }

        return $sitemap->writeToFile(public_path('sitemap-pages.xml'));
    }

    public function products()
    {
        $sitemap = Sitemap::create();

        $products = Product::published()->latest('updated_at')->get();

        foreach ($products as $product) {
            $sitemap->add(SitemapUrl::create(route('front.products.show', ['product' => $product]))
                ->setLastModificationDate($product->updated_at)
                ->setPriority(0.8)
                ->setChangeFrequency(SitemapUrl::CHANGE_FREQUENCY_DAILY));
        }

        return $sitemap->writeToFile(public_path('sitemap-products.xml'));
    }
}
