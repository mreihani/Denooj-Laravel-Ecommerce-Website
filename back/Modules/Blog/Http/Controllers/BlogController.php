<?php

namespace Modules\Blog\Http\Controllers;

use App\Http\Controllers\Controller;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\TwitterCard;
use Modules\Blog\Entities\Post;
use Modules\Blog\Entities\PostCategory;
use Modules\Products\Entities\Product;
use Spatie\SchemaOrg\FAQPage;
use Spatie\SchemaOrg\Schema;
use Spatie\Tags\Tag;

class BlogController extends Controller
{
    private $PER_PAGE = 16;

    public function index()
    {
        $posts = Post::published()->latest()->paginate($this->PER_PAGE);
        $title = 'وبلاگ';
        return view('blog::index', compact('posts', 'title'));
    }

    public function show(Post $post)
    {
        if ($post->status != 'published' && !auth()->guard('admin')->check()) {
            abort(404);
        }

        $related_category_ids = $post->categories->pluck('id');
        $similarPosts = Post::published()->whereHas('categories', function ($q) use ($related_category_ids) {
            $q->whereIn('category_id', $related_category_ids);
        })->where('id', '!=', $post->id)
            ->limit(6)
            ->get();

        $products = Product::where('recommended',true)->take(6)->get();
        views($post)->record();

        // meta tags
        SEOMeta::setTitle($post->getSeoTitle());
        SEOMeta::setDescription($post->meta_description);
        SEOMeta::setCanonical(route('post.show', $post));
        OpenGraph::setDescription($post->meta_description);
        OpenGraph::setTitle($post->getSeoTitle());
        OpenGraph::setUrl(route('post.show', $post));
        OpenGraph::addImage($post->getImage());
        OpenGraph::addProperty('updated_time', $post->updated_at);
        TwitterCard::setDescription($post->meta_description);
        TwitterCard::setUrl(route('post.show', $post));
        TwitterCard::addImage($post->getImage());
        $this->publicMetas();

        // schema
        $schema = Schema::webPage()
            ->name($post->title_tag)
            ->description($post->meta_description)
            ->url(route('post.show', $post))
            ->image($post->getImage());

        return view('blog::show', compact('post', 'similarPosts', 'products','schema'));
    }

    public function postCategory(PostCategory $category)
    {
        $posts = $category->posts()->published()->latest()->paginate($this->PER_PAGE);
        $title = $category->title;

        // meta tags
        SEOMeta::setTitle($category->getSeoTitle());
        SEOMeta::setDescription($category->meta_description);
        SEOMeta::setCanonical(route('post_category.show', $category));
        OpenGraph::setDescription($category->meta_description);
        OpenGraph::setTitle($category->getSeoTitle());
        OpenGraph::setUrl(route('post_category.show', $category));
        OpenGraph::addProperty('updated_time', $category->updated_at);
        TwitterCard::setDescription($category->meta_description);
        TwitterCard::setUrl(route('post_category.show', $category));
        $this->publicMetas();

        // schema
        $schema = Schema::webPage()
            ->name($category->title_tag)
            ->description($category->meta_description)
            ->url(route('post_category.show', $category));

        views($category)->record();
        return view('blog::index', compact('posts', 'title', 'category','schema'));
    }

    public function postTag($tag)
    {
        $tag = Tag::findFromString($tag,'Post');
        if (empty($tag)) return redirect(404);

        $posts = Post::withAnyTags([$tag->name],'Post')->published()
            ->latest()->paginate(16);
        $title = $tag->name;

        // meta tags
        SEOMeta::setTitle($tag->getSeoTitle());
        SEOMeta::setDescription($tag->meta_description);
        SEOMeta::setCanonical(route('post_tag.show', $tag->slug));
        OpenGraph::setDescription($tag->meta_description);
        OpenGraph::setTitle($tag->getSeoTitle());
        OpenGraph::setUrl(route('post_tag.show', $tag->slug));
        OpenGraph::addProperty('updated_time', $tag->updated_at);
        TwitterCard::setDescription($tag->meta_description);
        TwitterCard::setUrl(route('post_tag.show', $tag->slug));
        $this->publicMetas();

        // schema
        $schema = Schema::webPage()
            ->name($tag->title_tag)
            ->description($tag->meta_description)
            ->url(route('post_tag.show', $tag->slug));

        return view('blog::index', compact('posts', 'title', 'tag','schema'));
    }

//    public function blogSearch(){
//        $query = request('query');
//        if ($query) {
//            $posts = Search::add(Post::where('status', 'published'), ['title', 'slug'])
//                ->dontParseTerm()
//                ->beginWithWildcard()
//                ->paginate(10)->search($query);
//            $title = 'جستجو برای: ' . $query;
//            return view('front.posts', compact('posts', 'title'));
//        }
//        abort(404);
//    }
}
