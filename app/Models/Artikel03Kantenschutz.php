<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class Artikel03Kantenschutz extends Model
{
    use Sortable;
    //use SoftDeletes;

    //MassAssignment
    protected $guarded = [];
    //Table Name
    protected $table = 'artikel_03_05Kantenschuetze';
    public $primaryKey = 'id';

    public $timestamps = true;

    public $sortable = ['name'];

    public function projektPropeller(){
        return $this->hasMany(ProjektPropeller::class);
    }

}