<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;

class Kunde01Alt extends Model
{

    //MassAssignment
    protected $guarded = [];
    //Table Name
    protected $table = 'kunden_01Alt';
    // Primary Key
    public $primaryKey = 'id';

    public $timestamps = true;

}