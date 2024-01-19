<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Flansch extends Model
{
    //MassAssignment
    protected $guarded = [];
    //Table Name
    protected $table = 'motor_flansche';
    // Primary Key
    public $primaryKey = 'id';

    public $timestamps = true;



    public function motor(){
        return $this->belongsTo(Motor::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }


}