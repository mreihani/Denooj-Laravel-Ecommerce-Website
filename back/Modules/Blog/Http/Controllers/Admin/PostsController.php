<?php

namespace Modules\Blog\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Modules\Blog\Entities\Post;
use Modules\Blog\Http\Requests\CreatePostRequest;
use Modules\Blog\Http\Requests\UpdatePostRequest;
use Modules\Products\Entities\Product;
use Modules\Settings\Entities\SeoSetting;
use ProtoneMedia\LaravelCrossEloquentSearch\Search;
use Spatie\Tags\Tag;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role_or_permission:super-admin|see-posts'])->only(['index','search']);
        $this->middleware(['role_or_permission:super-admin|see-post-trash'])->only(['trash','searchTrash']);
        $this->middleware(['role_or_permission:super-admin|edit-posts'])->only(['edit','update']);
        $this->middleware(['role_or_permission:super-admin|delete-posts'])->only(['destroy','ajaxDelete']);
        $this->middleware(['role_or_permission:super-admin|add-post'])->only(['create','store']);
        $this->middleware(['role_or_permission:super-admin|force-delete-posts'])->only(['forceDelete','emptyTrash']);
        $this->middleware(['role_or_permission:super-admin|restore-posts'])->only(['restore']);
    }

    public function index()
    {
        $posts = Post::latest()->paginate(20);
        return view('blog::admin.posts.index',compact('posts'));
    }

    public function trash()
    {
        $posts = Post::onlyTrashed()->paginate(20);
        return view('blog::admin.posts.trash', compact('posts'));
    }

    public function create()
    {
        return view('blog::admin.posts.create');
    }

    public function store(CreatePostRequest $request)
    {
        $inputs = $request->all();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $inputs['image'] = $this->uploadImage($image,'posts');
        }

        $inputs['sidebar'] = false;
        if ($request->has('sidebar') && $request->sidebar == 'on') {
            $inputs['sidebar'] = true;
        }

        $inputs['show_thumbnail'] = false;
        if ($request->has('show_thumbnail') && $request->show_thumbnail == 'on') {
            $inputs['show_thumbnail'] = true;
        }

        $inputs['featured'] = false;
        if ($request->has('featured') && $request->featured == 'on') {
            $inputs['featured'] = true;
        }

        $inputs['display_comments'] = false;
        if ($request->has('display_comments') && $request->display_comments == 'on') {
            $inputs['display_comments'] = true;
        }

//        $inputs['meta_index'] = 'noindex';
//        if ($request->has('meta_index') && $request->meta_index == 'on') {
//            $inputs['meta_index'] = 'index';
//        }

        // generate slug from user input
        if ($request->has('slug') && !empty($request->slug)){
            $inputs['slug'] = SlugService::createSlug(Post::class, 'slug', str_replace('/','',$request->slug));
        }

        // faq
        $faq = array();
        foreach ($inputs as $key => $input) {
            if (str_starts_with($key, 'item_faq_')) {
                array_push($faq,$input);
            }
        }
        $inputs['faq'] = $faq;

        $post = Post::create($inputs);

        // attach categories
        $post->categories()->attach($request->categories);

        // attach keywords
        if (!empty($request->keywords)){
            $keys = explode(',',$request->keywords);
            $tags = [];
            foreach ($keys as $key){
                $tag = Tag::findOrCreate($key, 'Post');
                array_push($tags,$tag);
            }
            $post->attachTags($tags);
        }

        session()->flash('success', 'مقاله با موفقیت ذخیره شد.');
        return redirect(route('posts.edit',$post));
    }

    public function edit(Post $post)
    {
        return view('blog::admin.posts.edit',compact('post'));
    }

    public function update(UpdatePostRequest $request, Post $post)
    {

        $inputs = $request->all();

        // update slug
        if ($request->slug != $post->slug){
            $inputs['slug'] = SlugService::createSlug(Post::class, 'slug', str_replace('/','',$request->slug));
        }

        // image
        if ($request->remove_image != null) {
            $fileUrl = request('remove_image');
            $this->removeStorageFile($fileUrl);
            $inputs['image'] = null;
        }else{
            $inputs['image'] = $post->image;
        }
        if ($request->hasFile('image')) {
            $image      = $request->file('image');
            $inputs['image'] = $this->uploadImage($image,'posts');
        }

        $inputs['sidebar'] = false;
        if ($request->has('sidebar') && $request->sidebar == 'on') {
            $inputs['sidebar'] = true;
        }

        $inputs['show_thumbnail'] = false;
        if ($request->has('show_thumbnail') && $request->show_thumbnail == 'on') {
            $inputs['show_thumbnail'] = true;
        }

        $inputs['featured'] = false;
        if ($request->has('featured') && $request->featured == 'on') {
            $inputs['featured'] = true;
        }

        $inputs['display_comments'] = false;
        if ($request->has('display_comments') && $request->display_comments == 'on') {
            $inputs['display_comments'] = true;
        }

//        $inputs['meta_index'] = 'noindex';
//        if ($request->has('meta_index') && $request->meta_index == 'on') {
//            $inputs['meta_index'] = 'index';
//        }

        // faq
        $faq = array();
        foreach ($inputs as $key => $input) {
            if (str_starts_with($key, 'item_faq_')) {
                array_push($faq,$input);
            }
        }
        $inputs['faq'] = $faq;

        $post->update($inputs);

        // sync categories
        $post->categories()->sync($request->categories);

        // sync keywords
        $tags = [];
        if (!empty($request->keywords)){
            $keys = explode(',',$request->keywords);
            foreach ($keys as $key){
                $tag = Tag::findOrCreate($key, 'Post');
                array_push($tags,$tag);
            }
        }
        $post->syncTagsWithType($tags,'Post');


        session()->flash('success', 'تغییرات با موفقیت ذخیره شد.');
        return redirect(route('posts.edit',$post));
    }

    public function destroy(Post $post)
    {
        $name = $post->title;
        $post->delete();
        session()->flash('success','مقاله با عنوان ('.$name.') به سطل زبانه منتقل شد');
        return redirect(route('posts.index'));
    }

    public function restore($id)
    {
        $post = Post::withTrashed()->where('id',$id)->first();
        $name = $post->title;
        $post->restore();
        if ($post->categories()->count() < 1){
            $newCat = PostCategory::first();
            if ($newCat){
                $post->categories()->attach($newCat->id);
            }
        }
        session()->flash('success', 'مقاله با عنوان (' . $name . '.) با موفقیت بازگردانی شد');
        return redirect(route('posts.trash'));
    }

    public function forceDelete()
    {
        $post = Post::withTrashed()->where('id',request('id'))->first();
        $name = $post->title;

        // get image urls
        $imageArray = array();
        if ($post->image){
            array_push($imageArray,
                $post->image['thumb'],
                $post->image['large_thumb'],
                $post->image['medium'],
                $post->image['large'],
                $post->image['original']
            );
        }

        $post->categories()->sync([]);
        $post->forceDelete();

        // delete images
        if (count($imageArray) > 0){
            foreach ($imageArray as $img){
                $this->removeStorageFile($img);
            }
        }
        session()->flash('success', 'مقاله با عنوان (' . $name . ') با موفقیت حذف شد.');
        return redirect(route('posts.trash'));
    }

    public function emptyTrash()
    {
        Post::onlyTrashed()->forceDelete();
        session()->flash('success','زباله‌دان خالی شد.');
        return redirect(route('posts.trash'));
    }

    public function ajaxDelete(Request $request){
        $deleted = Post::where('id',$request->id)->delete();
        if ($deleted){
            session()->flash('success','مقاله به زباله‌دان منتقل شد.');
            return "success";
        }
        return "couldn't delete article";
    }

    public function search()
    {
        $query = request('query');
        $posts = Search::add(Post::class,['title','slug'])
            ->dontParseTerm()
            ->beginWithWildcard()
            ->paginate(20)->search($query);
        $posts->appends(array('query' => $query))->links();
        return view('blog::admin.posts.index', compact('posts', 'query'));
    }

    public function searchTrash()
    {
        $query = request('query');
        $posts = Post::onlyTrashed()->where('title', 'LIKE', '%' . $query . '%')
            ->orWhere('slug', 'LIKE', '%' . $query . '%')
            ->paginate(20);
        $posts->appends(array('query' => $query))->links();
        return view('blog::admin.posts.trash', compact('posts', 'query'));
    }
}
