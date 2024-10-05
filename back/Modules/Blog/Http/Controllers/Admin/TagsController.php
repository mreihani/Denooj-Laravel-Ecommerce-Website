<?php

namespace Modules\Blog\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use ProtoneMedia\LaravelCrossEloquentSearch\Search;
use Spatie\Tags\Tag;

class TagsController extends Controller
{

    public function index()
    {
        $post_tags = Tag::where('type','Post')->paginate(20);
        return view('blog::admin.tags.index',compact('post_tags'));
    }

    public function edit($post_tag)
    {
        $post_tag = Tag::findFromString($post_tag,'Post');
        return view('blog::admin.tags.edit',compact('post_tag'));
    }

    public function update(Request $request, $post_tag)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);
        $post_tag = Tag::findFromString($post_tag,'Post');
        $inputs = $request->except('_token');
        $post_tag->update($inputs);
        session()->flash('success','تغییرات با موفقیت ذخیره شد.');
        return redirect(route('post-tags.edit',$post_tag));
    }


    public function destroy($post_tag)
    {
        $post_tag = Tag::findFromString($post_tag,'Post');
        $name = $post_tag->name;
        $post_tag->delete();
        session()->flash('success','برچسب ('.$name.') با موفقیت حذف شد.');
        return redirect(route('post-tags.index'));
    }

    public function search(){
        $query = request('query');
        $post_tags = Search::add(Tag::where('type','Post'),['name->fa','slug->fa'])
            ->paginate(20)
            ->dontParseTerm()
            ->beginWithWildcard()
            ->search($query);
        $post_tags->appends(array('query' => $query))->links();
        return view('blog::admin.tags.index',compact('post_tags','query'));
    }
}
