<?php

namespace Modules\MenuBuilder\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\MenuBuilder\Entities\Menu;
use Modules\MenuBuilder\Entities\MenuItem;

class MenuItemsController extends Controller
{
    public function ajaxUpdate(Request $request)
    {
        $request->validate([
            'menu_item_id' => 'required',
            'title' => 'required|string|max:255',
            'link' => 'required|string|max:255',
            'parent_id' => 'nullable|string|max:255'
        ]);

        $menuItem = MenuItem::find($request->menu_item_id);
        if (!$menuItem){
            return response([
                'status' => 'error',
                'msg' => "couldn't find menu item!"
            ]);
        }

        $inputs = $request->all();
        $menuItem->update($inputs);
        return response([
            'status' => 'success',
            'item' => $menuItem
        ]);
    }

    public function ajaxDelete(Request $request)
    {
        $request->validate([
            'menu_item_id' => 'required',
        ]);

        $menuItem = MenuItem::find($request->menu_item_id);
        if (!$menuItem){
            return false;
        }

        // update all sub menus
        $menuItems = MenuItem::where('parent_id',$menuItem->id);
        $menuItems->update(['parent_id' => null]);

        $menuItem->delete();
        return true;
    }

    public function ajaxBulkDelete(Request $request)
    {
        $request->validate([
            'menu_id' => 'required',
            'ids' => 'required',
        ]);

        $ids = explode(',',$request->ids);
        foreach ($ids as $itemId){
            $menuItem = MenuItem::find($itemId);
            if (!$menuItem){
                return false;
            }
            // update all sub menus
            $menuItems = MenuItem::where('parent_id',$menuItem->id);
            $menuItems->update(['parent_id' => null]);
            $menuItem->delete();
        }
        return true;
    }

    public function ajaxCreate(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'link' => 'required|string|max:255',
            'menu_id' => 'required|string|max:255'
        ]);
        $inputs = $request->all();

        // set order
        $inputs['order'] = MenuItem::where('menu_id',$request->menu_id)->get()->count() + 1;

        $menuItem = MenuItem::create($inputs);
        return response([
            'status' => 'success',
            'item' => $menuItem
        ]);
    }

    public function getItems()
    {
        $menuId = request('menu_id');
        $menu = Menu::find($menuId);
        return $menu->items;
    }
}
