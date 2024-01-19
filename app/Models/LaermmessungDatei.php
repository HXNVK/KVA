<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class LaermmessungDatei extends Model
{

    //MassAssignment
    protected $guarded = [];
    //Table Name
    protected $table = 'laermmessung_daten';
    // Primary Key
    public $primaryKey = 'id';

    public $timestamps = true;

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function laermmessung(){
        return $this->belongsTo(Laermmessung::class);
    }




}