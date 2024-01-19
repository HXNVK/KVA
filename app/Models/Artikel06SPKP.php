<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class Artikel06SPKP extends Model
{
    use Sortable;
    //use SoftDeletes;

    //MassAssignment
    protected $guarded = [];
    //Table Name
    protected $table = 'artikel_06_03SPKP';
    // Primary Key
    public $primaryKey = 'id';

    public $timestamps = true;

    public $sortable = ['name'];

}