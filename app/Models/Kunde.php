<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class Kunde extends Model
{
    use Sortable;
    //use SoftDeletes;
    
    //MassAssignment
    protected $guarded = [];
    //Table Name
    protected $table = 'kunden';
    // Primary Key
    public $primaryKey = 'id';

    public $timestamps = true;

    public $sortable = ['id','matchcode','name1','name2'];


    public function kundeTyp(){
        return $this->belongsTo(KundeTyp::class);
    }   

    public function kundeGruppe(){
        return $this->belongsTo(KundeGruppe::class);
    }  

    public function kundeRating(){
        return $this->belongsTo(KundeRating::class);
    }
    
    public function kundeStatus(){
        return $this->belongsTo(KundeStatus::class);
    }  

    public function kundeAufkleber(){
        return $this->belongsTo(KundeAufkleber::class);
    }  

    public function user(){
        return $this->belongsTo(User::class);
    }
    
    public function kundeAdresse(){
        return $this->hasMany(KundeAdresse::class);
    } 

    public function kundeKontaktperson(){
        return $this->hasMany(KundeKontaktperson::class);
    } 

    public function kundeFinanzdatei(){
        return $this->hasMany(KundeFinanzdatei::class);
    } 

    public function fluggeraet(){
        return $this->hasMany(Fluggeraet::class);
    } 

}
