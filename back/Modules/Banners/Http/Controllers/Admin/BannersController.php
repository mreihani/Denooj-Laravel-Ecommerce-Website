<?php

namespace Modules\Banners\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Banners\Entities\Banner;
use ProtoneMedia\LaravelCrossEloquentSearch\Search;

class BannersController extends Controller
{

    public function index()
    {
        $banners = Banner::latest()->paginate(20);
        return view('banners::admin.index',compact('banners'));
    }

    public function create()
    {
        return view('banners::admin.create');

    }

    public function store(Request $request){
        $request->validate([
            'title' => 'required|string|max:255',
            'link' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'lg_col' => 'required|string|max:255',
            'sm_col' => 'required|string|max:255',
            'col' => 'required|string|max:255',
            'sort' => 'required|integer|min:1',
            'image' => 'required|string|max:1024',
        ]);
        $inputs = $request->all();
        Banner::create($inputs);

        session()->flash('success','بنر جدید با موفقیت اضافه شد.');
        return redirect(route('banners.create'));
    }

    public function edit(Banner $banner)
    {
        return view('banners::admin.edit',compact('banner'));
    }

    public function update(Request $request, Banner $banner)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'link' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'lg_col' => 'required|string|max:255',
            'sm_col' => 'required|string|max:255',
            'col' => 'required|string|max:255',
            'sort' => 'required|integer|min:1',
            'image' => 'required|string|max:1024',
        ]);
        $inputs = $request->all();
        $banner->update($inputs);
        session()->flash('success','تغییرات با موفقیت ذخیره شد.');
        return redirect(route('banners.edit',$banner));
    }

    public function destroy(Banner $banner)
    {
        $name = $banner->title;
        $banner->delete();
        session()->flash('success','بنر ('.$name.') با موفقیت حذف شد.');
        return redirect(route('banners.index'));
    }

    public function search(){
        $query = request('query');
        $banners = Search::add(Banner::class,['title'])
            ->paginate(20)
            ->dontParseTerm()
            ->beginWithWildcard()
            ->search($query);
        $banners->appends(array('query' => $query))->links();
        return view('banners::admin.index',compact('banners','query'));
    }
}
