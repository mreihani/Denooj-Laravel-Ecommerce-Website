<?php

namespace Modules\Redirects\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;
use Modules\Redirects\Entities\Redirect;
use ProtoneMedia\LaravelCrossEloquentSearch\Search;

class RedirectsController extends Controller
{

    public function index()
    {
        $redirects = Redirect::latest()->paginate(20);
        return view('redirects::index',compact('redirects'));
    }

    public function create()
    {
        return view('redirects::create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'old_url' => 'required|string|max:255',
            'new_url' => 'required|string|max:255',
            'type' => 'required'
        ]);

        $redirect = Redirect::create($request->all());
        session()->flash('success','ریدایرکت با موفقیت ایجاد شد.');
        return redirect(route('redirects.edit',$redirect));
    }


    public function edit(Redirect $redirect)
    {
        return view('redirects::edit',compact('redirect'));
    }

    public function update(Request $request, Redirect $redirect)
    {
        $request->validate([
            'old_url' => 'required|string|max:255',
            'new_url' => 'required|string|max:255',
            'type' => 'required'
        ]);

        $redirect->update($request->all());
        session()->flash('success','تغییرات با موفقیت ذخیره شد.');
        return redirect()->back();

    }

    public function destroy(Redirect $redirect)
    {
        $redirect->delete();
        Cache::forget('redirect_cache_routes');
        session()->flash('success','دیدایرکت با موفقیت حذف شد.');
        return redirect(route('redirects.index'));
    }

    public function search()
    {
        $query = request('query');
        $redirects = Search::add(Redirect::class,['old_url','new_url'])
            ->dontParseTerm()
            ->beginWithWildcard()
            ->paginate(20)->search($query);
        $redirects->appends(array('query' => $query))->links();
        return view('redirects::index', compact('redirects', 'query'));
    }

}
