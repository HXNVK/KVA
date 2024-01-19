<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class MyFactoryTransferArtikel extends Model
{

    //MassAssignment
    protected $guarded = [];
    //Table Name
    protected $table = 'mf_TransferArtikel';
    // Primary Key
    public $primaryKey = 'id';

    //public $timestamps = true;

}