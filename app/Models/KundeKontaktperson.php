<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class KundeKontaktperson extends Model
{
    use Sortable;
    
    //MassAssignment
    protected $guarded = [];
    //Table Name
    protected $table = 'kunde_kontaktpersonen';
    // Primary Key
    public $primaryKey = 'id';

    public $timestamps = true;

    public $sortable = ['kunde_id'];

    public function kunde(){
        return $this->belongsTo(Kunde::class);
    }  

    public function kundeKontaktpersonAnrede(){
        return $this->belongsTo(KundeKontaktpersonAnrede::class);
    }  

    public function kundeKontaktpersonPosition(){
        return $this->belongsTo(KundeKontaktpersonPosition::class);
    } 
}
