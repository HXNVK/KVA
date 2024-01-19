<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class Propeller extends Model
{
    use Sortable;
    //use SoftDeletes;

    //MassAssignment
    protected $guarded = [];
    //Table Name
    protected $table = 'propeller';
    // Primary Key
    public $primaryKey = 'id';

    public $timestamps = true;

    public $sortable = ['name'];

   
    public function artikel01Propeller(){
        return $this->belongsTo(Artikel01Propeller::class, 'artikel_01Propeller_id');
    }

    public function propellerForm(){
        return $this->belongsTo(PropellerForm::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}