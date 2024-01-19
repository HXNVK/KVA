<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class MyFactoryTransferKunde extends Model
{

    //MassAssignment
    protected $guarded = [];
    //Table Name
    protected $table = 'mf_TransferKunden';
    // Primary Key
    public $primaryKey = 'id';

    //public $timestamps = true;

}