<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class KundeGruppe extends Model
{
    use Sortable;
    
    //MassAssignment
    protected $guarded = [];
    //Table Name
    protected $table = 'kunde_gruppen';
    // Primary Key
    public $primaryKey = 'id';

    public $timestamps = true;

    public $sortable = ['name'];
    

    public function kunde(){
        return $this->hasMany(Kunde::class);
    }   

}
