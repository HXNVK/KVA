<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class ArduinoData extends Model
{

    //MassAssignment
    protected $guarded = [];
    //Table Name
    protected $table = 'arduino_data';
    // Primary Key
    public $primaryKey = 'id';

    public $timestamps = true;

}