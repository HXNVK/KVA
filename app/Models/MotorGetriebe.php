<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MotorGetriebe extends Model
{
    //MassAssignment
    protected $guarded = [];
    //Table Name
    protected $table = 'motor_getriebe';
    // Primary Key
    public $primaryKey = 'id';

    public $timestamps = true;

    
    public function projekt(){
        return $this->hasMany(Projekt::class);
    }

    public function motor(){
        return $this->belongsTo(Motor::class);
    }

    public function motorGetriebeArt(){
        return $this->belongsTo(MotorGetriebeArt::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }


}