<?php

namespace Modules\Products\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use ProtoneMedia\LaravelCrossEloquentSearch\Search;
use Spatie\Tags\Tag;

class TagsController extends Controller
{

    public function index()
    {
        $tags = Tag::where('type','Product')->paginate(20);
        return view('products::admin.tags.index',compact('tags'));
    }

    public function edit($tag)
    {
        $tag = Tag::findFromString($tag,'Product');
        return view('products::admin.tags.edit',compact('tag'));
    }

    public function update(Request $request, $tag)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);
        $tag = Tag::findFromString($tag,'Product');

        $inputs = $request->except('_token');
        $tag->update($inputs);
        session()->flash('success','تغییرات با موفقیت ذخیره شد.');
        return redirect(route('tags.edit',$tag));
    }

    public function destroy($tag)
    {
        $tag = Tag::findFromString($tag,'Product');
        $name = $tag->name;
        $tag->delete();
        session()->flash('success','برچسب ('.$name.') با موفقیت حذف شد.');
        return redirect(route('tags.index'));
    }

    public function search(){
        $query = request('query');
        $tags = Search::add(Tag::where('type','Product'),['name->fa','slug->fa'])
            ->paginate(20)
            ->dontParseTerm()
            ->beginWithWildcard()
            ->search($query);
        $tags->appends(array('query' => $query))->links();
        return view('products::admin.tags.index',compact('tags','query'));
    }
}
