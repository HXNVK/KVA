<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class Artikel02Modell extends Model
{
    use Sortable;
    //use SoftDeletes;

    //MassAssignment
    protected $guarded = [];
    //Table Name
    protected $table = 'artikel_02Modelle';
    // Primary Key
    public $primaryKey = 'id';

    public $timestamps = true;

    public $sortable = ['name'];

   
    public function user(){
        return $this->belongsTo(User::class);
    }
}