<?php

namespace Modules\Blog\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Modules\Blog\Entities\PostCategory;
use ProtoneMedia\LaravelCrossEloquentSearch\Search;

class PostCategoriesController extends Controller
{
    public function index()
    {
        $categories = PostCategory::latest()->paginate(20);
        return view('blog::admin.post_categories.index',compact('categories'));
    }

    public function create()
    {
        return view('blog::admin.post_categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'image' => 'nullable|mimes:jpeg,bmp,png,gif,svg,webp,jpg'
        ]);
        $inputs = $request->all();

        // generate slug from user input
        if ($request->has('slug') && !empty($request->slug)){
            $inputs['slug'] = SlugService::createSlug(PostCategory::class, 'slug', str_replace('/','',$request->slug));
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $inputs['image'] = $this->uploadRealFile($image,'post-categories');
        }

        $inputs['featured'] = false;
        if ($request->has('featured') && $request->featured == 'on') {
            $inputs['featured'] = true;
        }

        // faq
        $faq = array();
        foreach ($inputs as $key => $input) {
            if (str_starts_with($key, 'item_faq_')) {
                array_push($faq,$input);
            }
        }
        $inputs['faq'] = $faq;

        PostCategory::create($inputs);

        session()->flash('success','دسته بندی با موفقیت ایجاد شد.');
        return redirect(route('post-categories.index'));
    }

    public function edit(PostCategory $postCategory)
    {
        return view('blog::admin.post_categories.edit',compact('postCategory'));
    }

    public function update(Request $request, PostCategory $postCategory)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:350',
            'image' => 'nullable|mimes:jpeg,bmp,png,gif,svg,webp,jpg'
        ]);

        $inputs = $request->all();

        // update slug
        if ($request->slug != $postCategory->slug){
            $inputs['slug'] = SlugService::createSlug(PostCategory::class, 'slug', str_replace('/','',$request->slug));
        }

        if ($request->remove_image != null) {
            $fileUrl = request('remove_image');
            $this->removeStorageFile($fileUrl);
            $inputs['image'] = null;
        }
        if ($request->hasFile('image')) {
            $image      = $request->file('image');
            $inputs['image'] = $this->uploadRealFile($image,'post-categories');
        }

        $inputs['featured'] = false;
        if ($request->has('featured') && $request->featured == 'on') {
            $inputs['featured'] = true;
        }

        // faq
        $faq = array();
        foreach ($inputs as $key => $input) {
            if (str_starts_with($key, 'item_faq_')) {
                array_push($faq,$input);
            }
        }
        $inputs['faq'] = $faq;

        $postCategory->update($inputs);

        session()->flash('success','تغییرات با موفقیت ذخیره شد.');
        return redirect(route('post-categories.index'));
    }

    public function destroy(PostCategory $postCategory)
    {
        $name = $postCategory->title;
        $this->removeStorageFile($postCategory->image);
        $postCategory->delete();
        session()->flash('success','دسته بندی ('.$name.') با موفقیت حذف شد');
        return redirect(route('post-categories.index'));
    }

    public function search(){
        $query = request('query');
        $categories = Search::add(PostCategory::class,'title')
            ->dontParseTerm()
            ->beginWithWildcard()
            ->paginate(20)->search($query);
        $categories->appends(array('query' => $query))->links();
        return view('blog::admin.post_categories.index',compact('categories','query'));
    }
}
