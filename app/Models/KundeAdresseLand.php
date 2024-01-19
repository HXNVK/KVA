<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class KundeAdresseLand extends Model
{
    use Sortable;
    
    //MassAssignment
    protected $guarded = [];
    //Table Name
    protected $table = 'kunde_adresse_laender';
    // Primary Key
    public $primaryKey = 'id';

    public $timestamps = true;

    public $sortable = ['name','kuerzel'];


    public function kundeAdresse(){
        return $this->hasMany(KundeAdresse::class);
    }
}
