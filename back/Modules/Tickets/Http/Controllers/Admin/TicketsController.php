<?php

namespace Modules\Tickets\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Http\Request;
use Modules\Tickets\Entities\Ticket;

class TicketsController extends Controller
{

    public function index()
    {
        SEOMeta::setTitle('تیکت های پشتیبانی');
        $tickets = Ticket::latest()->paginate(20);
        return view('tickets::admin.index',compact('tickets'));
    }

    public function edit(Ticket $ticket)
    {
        SEOMeta::setTitle('ویرایش تیکت پشتیبانی');
        return view('tickets::admin.edit',compact('ticket'));
    }

    public function addResponse(Ticket $ticket,Request $request){

        $request->validate([
            'file' => 'nullable|mimes:jpg,png,jpeg,webp,rar,zip|max:10240'
        ]);


        if ($request->status == 'close'){
            $ticket->update(['status' => 'close']);
            session()->flash('success','تیکت با موفقیت بسته شد.');
        }else{
            if ($request->body == null){
                session()->flash('error','متن تیکت را وارد کنید.');
                return redirect()->back();
            }

            // check file
            $fileUrl = null;
            if ($request->has('file')){
                $file = $request->file('file');
                $fileUrl = $this->uploadRealFile($file,'tickets');
            }

            $ticket->responses()->create([
                'admin_id' => auth()->guard('admin')->id(),
                'body' => $request->body,
                'file' => $fileUrl
            ]);


            $ticket->update(['status' => 'support_response']);
//            SendSmsJob::dispatch($ticket->user->mobile, 's6c4twhyv32abqt', ['code' => $ticket->code]);
            session()->flash('success','پاسخ جدید با موفقیت ثبت شد.');
        }

        return redirect()->back();
    }

    public function destroy(Ticket $ticket)
    {
        $name = $ticket->title;
        $ticket->delete();
        session()->flash('success','تیکت با عنوان '.$name.' با موفقیت حذف شد.');
        return redirect(route('tickets.index'));
    }

    public function search()
    {
        $query = request('query');
        SEOMeta::setTitle('جستجو برای '.$query);
        $tickets = Ticket::whereHas('user', function ($q) use ($query) {
            $q->where('first_name', 'like', "%{$query}%");
        })
            ->orWhereHas('user', function ($q) use ($query) {
                $q->where('last_name', 'like', "%{$query}%");
            })
            ->orWhere('code', 'LIKE', '%' . $query . '%')
            ->paginate(20);
        return view('tickets::admin.index', compact('tickets', 'query'));
    }
}
