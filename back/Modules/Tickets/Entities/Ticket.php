<?php

namespace Modules\Tickets\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Users\Entities\User;

class Ticket extends Model
{
    protected $fillable = ['user_id','title','status','code'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function responses(){
        return $this->hasMany(TicketResponse::class);
    }
}
