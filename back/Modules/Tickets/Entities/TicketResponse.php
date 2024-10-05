<?php

namespace Modules\Tickets\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Modules\Admins\Entities\Admin;
use Modules\Users\Entities\User;

class TicketResponse extends Model
{
    protected $fillable = ['ticket_id', 'user_id', 'admin_id', 'body','file'];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function fromAdmin()
    {
        return $this->admin_id === null ? false : true;
    }


    function getExcerpt($startPos = 0, $maxLength = 100)
    {
        if (strlen($this->body) > $maxLength) {
            $excerpt = substr($this->body, $startPos, $maxLength - 3);
            $lastSpace = strrpos($excerpt, ' ');
            $excerpt = substr($excerpt, 0, $lastSpace);
            $excerpt .= '...';
        } else {
            $excerpt = $this->body;
        }

        return $excerpt;
    }


    public function getCreationDate(){
        return Carbon::createFromTimeStamp(strtotime($this->created_at))->diffForHumans(null,true) . ' پیش';
    }

    public function getFile(){
        if (!empty($this->file)){
            return '/storage' . $this->file;
        }
        return null;
    }

}
