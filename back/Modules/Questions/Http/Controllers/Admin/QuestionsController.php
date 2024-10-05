<?php

namespace Modules\Questions\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\SendSmsQuestionAnsweredJob;
use Illuminate\Http\Request;
use Modules\Products\Entities\Product;
use Modules\Questions\Entities\Question;
use ProtoneMedia\LaravelCrossEloquentSearch\Search;

class QuestionsController extends Controller
{

    public function index()
    {
        $questions = Question::has('product')->latest()->paginate(20);
        return view('questions::admin.index', compact('questions'));
    }

    public function edit(Question $question)
    {
        return view('questions::admin.edit', compact('question'));
    }

    public function update(Request $request, Question $question)
    {
        $request->validate([
            'text' => 'required|string|max:1024',
            'status' => 'required'
        ]);
        $question->update($request->all());
        session()->flash('success', 'تغییرات با موفقیت ذخیره شد.');
        return redirect(route('questions.edit', $question));
    }

    public function search()
    {
        $query = request('query');
        $questions = Search::add(Question::class, ['text', 'user.first_name','user.last_name','admin.name','user.mobile','user.email'])
            ->dontParseTerm()
            ->beginWithWildcard()
            ->paginate(20)->search($query);
        $questions->appends(array('query' => $query))->links();
        return view('questions::admin.index', compact('questions', 'query'));
    }

    public function approved()
    {
        $questionId = request('question_id');
        $question = Question::find($questionId);
        if (!$questionId) {
            return "error";
        }
        $question->update(['status' => 'published']);
        return "success";
    }

    public function unapproved()
    {
        $questionId = request('question_id');
        $question = Question::find($questionId);
        if (!$questionId) {
            return "error";
        }
        $question->update(['status' => 'pending']);
        return "success";
    }

    public function delete()
    {

        try {
            $questionId = request('question_id');
            $question = Question::find($questionId);
            if (!$questionId) {
                return "error";
            }
            if ($question->responses) {
                foreach ($question->responses as $re) {
                    $re->delete();
                }
            }

            $question->update(['parent_id' => null]);
            $question->delete();

        } catch (\Exception $e) {
            return $e;
        }
        return "success";
    }

    public function addResponse(Request $request)
    {
        $request->validate([
            'text' => 'required'
        ]);
        $inputs = $request->all();
        $inputs['admin_id'] = auth()->guard('admin')->user()->id;
        $inputs['model_id'] = $request->product_id;
        $inputs['model_type'] = 'product';
        $inputs['status'] = 'published';
        Question::create($inputs);

        // notify user via sms if question alarm enabled
        $respondedQuestion = Question::find($request->parent_id);
        if ($respondedQuestion->alarm){
            if($inputs['model_type'] == 'product'){
                $product = Product::find($request->product_id);
                $link = route('product.short_url',$product->code);
            }else{
                $link = route('home');
            }
            SendSmsQuestionAnsweredJob::dispatch($respondedQuestion->user->mobile,$link);
        }

        session()->flash('success', 'پاسخ شما با موفقیت ثبت شد.');
        return redirect()->back();
    }

}
