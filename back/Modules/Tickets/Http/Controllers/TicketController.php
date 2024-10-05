<?php

namespace Modules\Tickets\Http\Controllers;


use App\Http\Controllers\Controller;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Http\Request;
use Modules\Tickets\Entities\Ticket;

class TicketController extends Controller
{
    public function index(){
        SEOMeta::setTitle('تیکت ها');
        $tickets = auth()->user()->tickets()->paginate(15);
        return view('tickets::index',compact('tickets'));
    }

    public function store(Request $request){
        $request->validate([
            'title' => 'required',
            'body' => 'required',
            'file' => 'nullable|mimes:jpg,png,jpeg,webp,rar,zip|max:10240'
        ]);
        $inputs = $request->except('_token');
        $code = rand(1111111111, 9999999999);
        $inputs['code'] = $code;
        $ticket = auth()->user()->tickets()->create($inputs);

        // check file
        $fileUrl = null;
        if ($request->has('file')){
            $file = $request->file('file');
            $fileUrl = $this->uploadRealFile($file,'tickets');
        }
        $ticket->responses()->create([
            'user_id' => auth()->id(),
            'body' => $request->body,
            'file' => $fileUrl
        ]);


        session()->flash('success','درخواست پشتیبانی شما با موفقیت ثبت شد. به محض پاسخ پشتیبانی به شما از طریق پیامک اطلاع رسانی خواهد شد.');
        return redirect(route('panel.tickets'));
    }

    public function show(Ticket $ticket){
        SEOMeta::setTitle('مشاهده تیکت');
        $messages = $ticket->responses;
        return view('tickets::show',compact('ticket','messages'));
    }

    public function addResponse(Ticket $ticket,Request $request){
        $request->validate([
            'body' => 'required',
            'file' => 'nullable|mimes:jpg,png,jpeg,webp,rar,zip|max:10240'
        ]);

        // check file
        $fileUrl = null;
        if ($request->has('file')){
            $file = $request->file('file');
            $fileUrl = $this->uploadRealFile($file,'tickets');
        }

        $ticket->responses()->create([
            'user_id' => auth()->id(),
            'body' => $request->body,
            'file' => $fileUrl
        ]);

        $status = 'user_response';
        if ($ticket->responses->count() < 2) {
            $status = 'pending';
        }
        $ticket->update(['status' => $status]);

        session()->flash('success','پاسخ جدید شما به این تیکت با موفقیت ثبت شد.');
        return redirect()->back();
    }
}
