<?php

namespace Modules\Questions\Http\Controllers;

use App\Jobs\SendMailJob;
use App\Jobs\SendSmsQuestionSubmittedJob;
use App\Notifications\NewQuestionSubmitted;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Admins\Entities\Admin;
use Modules\Products\Entities\Product;
use Modules\Questions\Entities\Question;

class QuestionsController extends Controller
{
    public function submitQuestion(Request $request, Product $product){
        $request->validate([
            'text' => 'required|string|max:2048'
        ]);

        $inputs = $request->all();

        $inputs['alarm'] = false;
        if ($request->has('alarm') && $request->alarm == 'on'){
            $inputs['alarm'] = true;
        }

        $inputs['user_id'] = auth()->user()->id;
        $inputs['model_id'] = $product->id;
        $inputs['model_type'] = 'product';

        $question = Question::create($inputs);
        session()->flash('success','پرسش شما با موفقیت ثبت شد و پس از تایید نمایش داده خواهد شد.');

        // notify super admins via email
        if (allow_question_email()){
            $admins = Admin::Role('super-admin')->get();
            SendMailJob::dispatch($admins,new NewQuestionSubmitted($question));
        }

        // notify super admin via sms
        if (allow_question_sms()){
            $admins = Admin::Role('super-admin')->where('mobile','!=',null)->get();
            foreach ($admins as $admin){
                SendSmsQuestionSubmittedJob::dispatch($admin->mobile,$product->id);
            }
        }

        return redirect()->back();
    }

}
