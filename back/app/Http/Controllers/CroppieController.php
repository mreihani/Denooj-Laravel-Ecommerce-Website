<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CroppieController extends Controller
{

    public function avatar(Request $request)
    {
        if ($request->ajax()) {
            $images = $this->uploadImage($request->image,'users',['original' => 400],80,false);
			return json_encode(
				array(
					'response' => 'success',
					'url' =>$images
				)
			);
        }
        return "Access Denied!";
    }

}
