<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class LaermmessungAlpha extends Model
{

    //MassAssignment
    protected $guarded = [];
    //Table Name
    protected $table = 'laermmessung_alpha';
    // Primary Key
    public $primaryKey = 'RH';

    public $timestamps = true;

}