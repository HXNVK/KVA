<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class KundeFinanzdatei extends Model
{
    use Sortable;
    
    //MassAssignment
    protected $guarded = [];
    //Table Name
    protected $table = 'kunde_finanzdaten';
    // Primary Key
    public $primaryKey = 'id';

    public $timestamps = true;

    public $sortable = ['kunde_id','steuernummer'];

    public function kunde(){
        return $this->belongsTo(Kunde::class);
    }  

    public function kundeFinanzdateiZahlungsart(){
        return $this->belongsTo(KundeFinanzdateiZahlungsart::class);
    }  

    public function kundeFinanzdateiZahlungsziel(){
        return $this->belongsTo(KundeFinanzdateiZahlungsziel::class);
    } 

}
