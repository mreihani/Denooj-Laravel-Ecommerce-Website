<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Modules\Blog\Entities\Post;
use Modules\Blog\Entities\PostCategory;
use Modules\Pages\Entities\Page;
use Modules\Products\Entities\Category;
use Modules\Products\Entities\Product;
use Spatie\Tags\Tag;

class SitemapController extends Controller
{
    public function index()
    {
        return response()->view('sitemap.index')->header('Content-Type', 'text/xml');
    }

    public function pages()
    {
        $pages = Page::published()->latest()->get();
        return response()->view('sitemap.pages', compact('pages'))
            ->header('Content-Type', 'text/xml');
    }

    public function products()
    {
        $products = Product::published()->latest()->get();
        return response()->view('sitemap.product', compact('products'))->header('Content-Type', 'text/xml');
    }

    public function posts()
    {
        $posts = Post::published()->latest()->get();
        return response()->view('sitemap.post', compact('posts'))->header('Content-Type', 'text/xml');
    }

    public function categories()
    {
        $categories = Category::latest()->get();
        return response()->view('sitemap.category', compact('categories'))->header('Content-Type', 'text/xml');
    }

    public function postCategories()
    {
        $categories = PostCategory::latest()->get();
        return response()->view('sitemap.post-category', compact('categories'))->header('Content-Type', 'text/xml');
    }

    public function tags()
    {
        $tags = Tag::where('type','Product')->latest()->get();
        return response()->view('sitemap.tag', compact('tags'))->header('Content-Type', 'text/xml');
    }

    public function postTags()
    {
        $tags = Tag::where('type','Post')->latest()->get();
        return response()->view('sitemap.post-tag', compact('tags'))->header('Content-Type', 'text/xml');
    }

    public function statics()
    {
        return response()->view('sitemap.statics')->header('Content-Type', 'text/xml');
    }

}
