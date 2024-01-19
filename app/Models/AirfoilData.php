<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;

class AirfoilData extends Model
{

    //MassAssignment
    protected $guarded = [];
    //Table Name
    protected $table = 'airfoil_data';
    // Primary Key
    public $primaryKey = 'id';

    public $timestamps = true;

}