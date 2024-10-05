<?php

namespace Modules\Comments\Http\Controllers;

use App\Jobs\SendMailJob;
use App\Jobs\SendSmsPostCommentJob;
use App\Jobs\SendSmsProductCommentJob;
use App\Notifications\NewCommentSubmitted;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Admins\Entities\Admin;
use Modules\Blog\Entities\Post;
use Modules\Comments\Entities\Comment;
use Modules\Products\Entities\Product;

class CommentsController extends Controller
{
    public function addComment(Request $request){

        $request->validate([
            'comment' => 'required|string|max:2048',
            'score' => 'required|numeric|min:1|max:5',
            'product_id' => 'required|string|max:2048'
        ]);

        $inputs = $request->all();
        $product = Product::find($request->product_id);
        if (!$product){
            return response([
                'status' => 'error',
                'msg' => 'محصول مورد نظر یافت نشد!'
            ]);
        }

        $inputs['from_buyer'] = false;
        if ($product->isBoughtByUser(auth()->user()->id)){
            $inputs['from_buyer'] = true;
        }

        $inputs['anonymous'] = false;
        if ($request->has('anonymous') && $request->anonymous == 'true'){
            $inputs['anonymous'] = true;
        }

        if ($request->weaknesses != null){
            $inputs['weaknesses'] = explode(',',$request->weaknesses);
        }

        if ($request->strengths != null){
            $inputs['strengths'] = explode(",",$request->strengths);
        }


        $inputs['user_id'] = auth()->user()->id;

        $comment = Comment::create($inputs);

        // notify super admins via email
        if (allow_product_comment_email()){
            $admins = Admin::Role('super-admin')->get();
            SendMailJob::dispatch($admins,new NewCommentSubmitted($comment));
        }

        // notify super admin via sms
        if (allow_product_comment_sms()){
            $admins = Admin::Role('super-admin')->where('mobile','!=',null)->get();
            foreach ($admins as $admin){
                SendSmsProductCommentJob::dispatch($admin->mobile,$product->id);
            }
        }

        return response([
            'status' => 'success',
            'msg' => 'دیدگاه شما با موفقیت ثبت شد و پس از بررسی نمایش داده میشود.'
        ]);
    }

    public function addCommentForPost(Request $request){

        $request->validate([
            'comment' => 'required|string|max:2048',
            'post_id' => 'required|string|max:2048'
        ]);

        $inputs = $request->all();
        $post = Post::find($request->post_id);
        if (!$post){
            return response([
                'status' => 'error',
                'msg' => 'مقاله مورد نظر یافت نشد!'
            ]);
        }

        $inputs['anonymous'] = false;
        if ($request->has('anonymous') && $request->anonymous == 'true'){
            $inputs['anonymous'] = true;
        }

        $inputs['user_id'] = auth()->user()->id;
        $inputs['score'] = '5';

        $comment = Comment::create($inputs);


        // notify super admins via email
        if (allow_post_comment_email()){
            $admins = Admin::Role('super-admin')->get();
            SendMailJob::dispatch($admins,new NewCommentSubmitted($comment));
        }

        // notify super admin via sms
        if (allow_post_comment_sms()){
            $admins = Admin::Role('super-admin')->where('mobile','!=',null)->get();
            foreach ($admins as $admin){
                SendSmsPostCommentJob::dispatch($admin->mobile,$post->id);
            }
        }


        return response([
            'status' => 'success',
            'msg' => 'دیدگاه شما با موفقیت ثبت شد و پس از بررسی نمایش داده میشود.'
        ]);
    }
}
