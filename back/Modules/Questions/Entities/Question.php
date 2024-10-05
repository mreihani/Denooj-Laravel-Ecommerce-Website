<?php

namespace Modules\Questions\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Modules\Admins\Entities\Admin;
use Modules\Products\Entities\Product;
use Modules\Users\Entities\User;

class Question extends Model
{
    protected $fillable =[
        'model_type',
        'model_id',
        'user_id',
        'parent_id',
        'admin_id',
        'status',
        'text',
        'alarm'
    ];

    public function product(){
        return $this->belongsTo(Product::class,'model_id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function admin(){
        return $this->belongsTo(Admin::class,'admin_id');
    }

    public function responses(){
        return $this->hasMany(Question::class,'parent_id')->latest();
    }


    public function parent(){
        return $this->belongsTo(Question::class,'parent_id');
    }

    public function isFromAdmin(){
        return $this->admin_id != null;
    }

    public function getLevel(){
        if ($this->parent){
            if ($this->parent->parent){
                if ($this->parent->parent->parent){
                    if ($this->parent->parent->parent->parent){
                        if ($this->parent->parent->parent->parent->parent){
                            return 6;
                        }
                        return 5;
                    }
                    return 4;
                }

                return 3;
            }
            return 2;
        }
        return 1;
    }

    public function getAllResponses(){

        $questions = Question::where('parent_id',$this->id)->get()->toArray();

        foreach ($questions as $ques1) {
            $responsesLvl1 = Question::where('parent_id',$ques1['id'])->get()->toArray();
            foreach ($responsesLvl1 as $res1){
                array_push($questions,$res1);
            }

            foreach ($responsesLvl1 as $res2) {
                $responsesLvl2 = Question::where('parent_id',$res2['id'])->get()->toArray();
                foreach ($responsesLvl2 as $res2){
                    array_push($questions,$res2);
                }

                foreach ($responsesLvl2 as $res3) {
                    $responsesLvl3 = Question::where('parent_id',$res3['id'])->get()->toArray();
                    foreach ($responsesLvl3 as $res3){
                        array_push($questions,$res3);
                    }
                }
            }
        }

        return collect($questions);
    }

    public function getSenderName(){
        if ($this->admin_id == null){
            return $this->user->getPublicName();
        }
        return $this->admin->name;
    }

    public function getSenderAvatar(){
        if ($this->admin_id == null){
            return $this->user->getAvatar(true);
        }
        return $this->admin->getAvatar();
    }

    public function getResponseToName(){
        if ($this->parent_id == null){
            return "";
        }
        return $this->parent->getSenderName();
    }



    public function getCreationDate(){
        return Carbon::createFromTimeStamp(strtotime($this->created_at))->diffForHumans(null,true).' پیش';
    }

}
