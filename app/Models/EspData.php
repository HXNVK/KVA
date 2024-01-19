<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class EspData extends Model
{

    //MassAssignment
    protected $guarded = [];
    //Table Name
    protected $table = 'esp_data';
    // Primary Key
    public $primaryKey = 'id';

    public $timestamps = true;

}