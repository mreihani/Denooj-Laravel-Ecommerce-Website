<?php

namespace Modules\Products\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateCategoryRequest;
use App\Http\Requests\Admin\UpdateCategoryRequest;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Modules\Products\Entities\Category;
use ProtoneMedia\LaravelCrossEloquentSearch\Search;

class CategoriesController extends Controller
{

    public function index()
    {
        $categories = Category::latest()->paginate(20);
        return view('products::admin.categories.index',compact('categories'));
    }

    public function create()
    {
        return view('products::admin.categories.create');

    }

    public function store(CreateCategoryRequest $request){
        $inputs = $request->all();

        // generate slug from user input
        if ($request->has('slug') && !empty($request->slug)){
            $inputs['slug'] = SlugService::createSlug(Category::class, 'slug', str_replace('/','',$request->slug));
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $inputs['image'] = $this->uploadRealFile($image,'categories');
        }

        $inputs['featured'] = false;
        if ($request->has('featured') && $request->featured == 'on') {
            $inputs['featured'] = true;
        }

        $inputs['display_in_home'] = false;
        if ($request->has('display_in_home') && $request->display_in_home == 'on') {
            $inputs['display_in_home'] = true;
        }

        // faq
        $faq = array();
        foreach ($inputs as $key => $input) {
            if (str_starts_with($key, 'item_faq_')) {
                array_push($faq,$input);
            }
        }
        $inputs['faq'] = $faq;

        Category::create($inputs);

        session()->flash('success','دسته بندی با موفقیت ایجاد شد.');
        return redirect(route('categories.create'));
    }

    public function edit(Category $category)
    {
        return view('products::admin.categories.edit',compact('category'));
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $inputs = $request->except('_token');

        // update slug
        if ($request->slug != $category->slug){
            $inputs['slug'] = SlugService::createSlug(Category::class, 'slug', str_replace('/','',$request->slug));
        }

        if ($request->remove_image != null) {
            $fileUrl = request('remove_image');
            $this->removeStorageFile($fileUrl);
            $inputs['image'] = null;
        }
        if ($request->hasFile('image')) {
            $image      = $request->file('image');
            $inputs['image'] = $this->uploadRealFile($image,'categories');
        }

        $inputs['featured'] = false;
        if ($request->has('featured') && $request->featured == 'on') {
            $inputs['featured'] = true;
        }

        $inputs['display_in_home'] = false;
        if ($request->has('display_in_home') && $request->display_in_home == 'on') {
            $inputs['display_in_home'] = true;
        }

        // faq
        $faq = array();
        foreach ($inputs as $key => $input) {
            if (str_starts_with($key, 'item_faq_')) {
                array_push($faq,$input);
            }
        }
        $inputs['faq'] = $faq;

        $category->update($inputs);
        session()->flash('success','تغییرات با موفقیت ذخیره شد.');
        return redirect(route('categories.edit',$category));
    }

    public function destroy(Category $category)
    {
        $name = $category->title;
        // TODO delete products
        $category->delete();
        session()->flash('success','دسته بندی ('.$name.') با موفقیت حذف شد.');
        return redirect(route('categories.index'));
    }

    public function search(){
        $query = request('query');
        $categories = Search::add(Category::class,['title','slug'])
            ->paginate(20)
            ->dontParseTerm()
            ->beginWithWildcard()
            ->search($query);
        $categories->appends(array('query' => $query))->links();
        return view('products::admin.categories.index',compact('categories','query'));
    }
}
