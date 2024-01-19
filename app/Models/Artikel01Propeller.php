<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class Artikel01Propeller extends Model
{
    use Sortable;
    //use SoftDeletes;

    //MassAssignment
    protected $guarded = [];
    //Table Name
    protected $table = 'artikel_01Propeller';
    // Primary Key
    public $primaryKey = 'id';

    public $timestamps = true;

    public $sortable = ['name'];

    public function propellerKlasseGeometrie(){
        return $this->belongsTo(PropellerKlasseGeometrie::class, 'propeller_klasse_geometrie_id');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}