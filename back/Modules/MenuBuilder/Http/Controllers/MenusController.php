<?php

namespace Modules\MenuBuilder\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\MenuBuilder\Entities\Menu;
use Modules\MenuBuilder\Entities\MenuItem;

class MenusController extends Controller
{
    public function index(Request $request)
    {
        $menus = Menu::latest()->paginate(20);
        $compact = compact('menus');
        if($request->has('menu_id') && !empty($request->menu_id)){
            $menu = Menu::find($request->menu_id);
            if ($menu){
                $compact =  compact(['menus','menu']);
            }
        }
        return view('menubuilder::index',$compact);
    }

    public function create()
    {
        return view('menubuilder::create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'locations' => 'nullable',
        ]);

        $inputs = $request->all();
        $menu = Menu::create($inputs);

        session()->flash('success','منو جدید با موفقیت ایجاد شد.');
        return redirect(route('menus.index') . '?menu_id=' . $menu->id);
    }

    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'locations' => 'nullable',
        ]);

        // update menu items
        foreach ($request->all() as $key => $value) {
            if (str_starts_with($key,'item_')){
                $itemId = explode('_',$key)[1];
                $menuItem = MenuItem::find($itemId);
                if ($menuItem){
                    $val = explode('_',$value);
                    $order = $val[0];
                    $parent = null;
                    if (array_key_exists(1,$val) && $val[1] != '' && $val[1] != '0' && $val[1] != 'undefined'){
                        $parent = $val[1];
                    }

                    // check parent depth
                    if ($parent != ''){
                        $parentItem = MenuItem::find($parent);
                        if ($parentItem && $parentItem->getDepth() > 2){
                            $parent = null;
                        }
                    }

                    $menuItem->update(['order' => $order,'parent_id' => $parent]);
                }
            }
        }

        $inputs = $request->all();

        if (!$request->has('locations') || empty($request->locations)){
            $inputs['locations'] = [];
        }

        $menu->update($inputs);
        session()->flash('success','تغییرات با موفقیت ذخیره شد.');
        return redirect(route('menus.index') . '?menu_id=' . $menu->id);
    }

    public function ajaxUpdateItems(Request $request)
    {
        // update menu items
        foreach ($request->all() as $key => $value) {
            if (str_starts_with($key,'item_')){
                $itemId = explode('_',$key)[1];
                $menuItem = MenuItem::find($itemId);
                if ($menuItem){
                    $val = explode('_',$value);
                    $order = $val[0];
                    $parent = null;
                    if (array_key_exists(1,$val) && $val[1] != '' && $val[1] != '0' && $val[1] != 'undefined'){
                        $parent = $val[1];
                    }

                    // check parent depth
                    if ($parent != ''){
                        $parentItem = MenuItem::find($parent);
                        if ($parentItem && $parentItem->getDepth() > 2){
                            $parent = null;
                        }
                    }

                    $menuItem->update(['order' => $order,'parent_id' => $parent]);
                }
            }
        }


        return true;
    }

    public function destroy(Menu $menu)
    {
        $name = $menu->title;
        $menu->delete();
        session()->flash('success','منو ('.$name.') با موفقیت حذف شد');
        return redirect(route('menus.index'));
    }
}
