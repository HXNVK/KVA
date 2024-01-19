<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Laermmessung extends Model
{

    //MassAssignment
    protected $guarded = [];
    //Table Name
    protected $table = 'laermmessungen';
    // Primary Key
    public $primaryKey = 'id';

    public $timestamps = true;

    public function kunde(){
        return $this->belongsTo(Kunde::class);
    }

    public function fluggeraet(){
        return $this->belongsTo(Fluggeraet::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

}