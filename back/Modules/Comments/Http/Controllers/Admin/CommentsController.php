<?php

namespace Modules\Comments\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Comments\Entities\Comment;
use ProtoneMedia\LaravelCrossEloquentSearch\Search;

class CommentsController extends Controller
{

    public function index()
    {
        $comments = Comment::latest()->paginate(20);
        return view('comments::admin.index', compact('comments'));
    }

    public function edit(Comment $comment)
    {
        return view('comments::admin.edit', compact('comment'));
    }

    public function update(Request $request, Comment $comment)
    {
        $request->validate([
            'comment' => 'required|string|max:2048',
            'status' => 'required',
            'score' => 'nullable|numeric|min:1|max:5',
        ]);
        $inputs = $request->all();

        if ($request->has('anonymous') && $request->anonymous == 'on'){
            $inputs['anonymous'] = true;
        }else{
            $inputs['anonymous'] = false;
        }

        if ($request->weaknesses != null){
            $inputs['weaknesses'] = explode(',',$request->weaknesses);
        }

        if ($request->strengths != null){
            $inputs['strengths'] = explode(",",$request->strengths);
        }

        $comment->update($inputs);
        session()->flash('success', 'تغییرات با موفقیت ذخیره شد.');
        return redirect(route('comments.edit', $comment));
    }

    public function search()
    {
        $query = request('query');
        $comments = Search::add(Comment::class, ['comment', 'user.first_name','user.last_name','user.mobile','user.email'])
            ->dontParseTerm()
            ->beginWithWildcard()
            ->paginate(20)->search($query);
        $comments->appends(array('query' => $query))->links();
        return view('comments::admin.index', compact('comments', 'query'));
    }

    public function approved()
    {
        $commentId = request('comment_id');
        $comment = Comment::find($commentId);
        if (!$commentId) {
            return "error";
        }
        $comment->update(['status' => 'published']);
        return "success";
    }

    public function unapproved()
    {
        $commentId = request('comment_id');
        $comment = Comment::find($commentId);
        if (!$commentId) {
            return "error";
        }
        $comment->update(['status' => 'pending']);
        return "success";
    }

    public function delete()
    {
        try {
            $commentId = request('comment_id');
            $comment = Comment::find($commentId);
            if (!$commentId) {
                return "error";
            }
            $comment->delete();
        } catch (\Exception $e) {
            return $e;
        }
        return "success";
    }

}
