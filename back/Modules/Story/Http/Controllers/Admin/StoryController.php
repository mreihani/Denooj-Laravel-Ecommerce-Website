<?php

namespace Modules\Story\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Story\Entities\Story;
use ProtoneMedia\LaravelCrossEloquentSearch\Search;

class StoryController extends Controller
{

    public function index()
    {
        $stories = Story::latest()->paginate(20);
        return view('story::admin.index',compact('stories'));
    }

    public function create()
    {
        return view('story::admin.create');

    }

    public function store(Request $request){
        $request->validate([
            'author_id' => 'required',
            'title' => 'required|string|max:255',
            'thumbnail' => 'required|string|max:1024',
            'type' => 'required',
            'status' => 'required',
            'image_url' => 'nullable|required_if:type,image|string|max:1024',
            'video_url' => 'nullable|required_if:type,video|string|max:1024',
            'button_text' => 'nullable|required_if:show_button,on|string|max:255',
            'button_link' => 'nullable|required_if:show_button,on|string|max:255',
            'description' => 'nullable|string|max:255'
        ]);
        $inputs = $request->all();

        if (!empty($request->show_button) && $request->show_button == 'on'){
            $inputs['show_button'] = true;
        }else{
            $inputs['show_button'] = false;
        }

        $story = Story::create($inputs);

        // attach products
        if (!empty($request->products) && count($request->products) > 0){
            $story->products()->attach($request->products);
        }

        session()->flash('success','داستان با موفقیت ایجاد شد.');
        return redirect(route('stories.index'));
    }

    public function edit(Story $story)
    {
        return view('story::admin.edit',compact('story'));
    }

    public function update(Request $request, Story $story)
    {
        $request->validate([
            'author_id' => 'required',
            'title' => 'required|string|max:255',
            'thumbnail' => 'required|string|max:1024',
            'type' => 'required',
            'status' => 'required',
            'image_url' => 'nullable|required_if:type,image|string|max:1024',
            'video_url' => 'nullable|required_if:type,video|string|max:1024',
            'button_text' => 'nullable|required_if:show_button,on|string|max:255',
            'button_link' => 'nullable|required_if:show_button,on|string|max:255',
            'description' => 'nullable|string|max:255'
        ]);
        $inputs = $request->all();

        if (!empty($request->show_button) && $request->show_button == 'on'){
            $inputs['show_button'] = true;
        }else{
            $inputs['show_button'] = false;
        }

        $story->update($inputs);

        // sync products
        $story->products()->sync($request->products);


        session()->flash('success','تغییرات با موفقیت ذخیره شد.');
        return redirect(route('stories.edit',$story));
    }

    public function destroy(Story $story)
    {
        $name = $story->title;
        $story->delete();
        session()->flash('success','داستان ('.$name.') با موفقیت حذف شد.');
        return redirect(route('stories.index'));
    }

    public function search(){
        $query = request('query');
        $stories = Search::add(Story::class,['title'])
            ->paginate(20)
            ->dontParseTerm()
            ->beginWithWildcard()
            ->search($query);
        $stories->appends(array('query' => $query))->links();
        return view('story::admin.index',compact('stories','query'));
    }
}
