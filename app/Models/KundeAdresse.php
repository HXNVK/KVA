<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class KundeAdresse extends Model
{
    use Sortable;
    
    //MassAssignment
    protected $guarded = [];
    //Table Name
    protected $table = 'kunde_adressen';
    // Primary Key
    public $primaryKey = 'id';

    public $timestamps = true;

    public $sortable = ['kunde_id','strasse','stadt'];

    public function kunde(){
        return $this->belongsTo(Kunde::class);
    }  
    
    public function kundeAdresseLand(){
        return $this->belongsTo(KundeAdresseLand::class);
    }  

    public function kundeAdresseTyp(){
        return $this->belongsTo(KundeAdresseTyp::class);
    }  
}
