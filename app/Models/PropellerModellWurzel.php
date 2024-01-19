<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PropellerModellWurzel extends Model
{
    use SoftDeletes;

    //MassAssignment
    protected $guarded = [];
    //Table Name
    protected $table = 'propeller_modell_wurzeln';
    // Primary Key
    public $primaryKey = 'id';

    public $timestamps = true;
    
    public $sortable = ['name', 'propeller_modell_kompatibilitaet_id','propeller_klasse_geometrie_id','propeller_drehrichtung_id','winkel','bereichslaenge'];
    
    public function propellerForm(){
        return $this->hasMany(PropellerForm::class);
    }  
    
    public function propellerKlasseGeometrie(){
        return $this->belongsTo(PropellerKlasseGeometrie::class);
    }
    
    public function propellerModellKompatibilitaet(){
        return $this->belongsTo(PropellerModellKompatibilitaet::class);
    }
  
    public function propellerDrehrichtung(){
        return $this->belongsTo(PropellerDrehrichtung::class);
    }
    
    public function propellerModellWurzelTyp(){
        return $this->belongsTo(PropellerModellWurzelTyp::class);
    }
    
    public function user(){
        return $this->belongsTo(User::class);
    }   
}
