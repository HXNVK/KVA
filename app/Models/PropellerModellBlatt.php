<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class PropellerModellBlatt extends Model
{
    use Sortable;
    use SoftDeletes;

    //MassAssignment
    protected $guarded = [];
    //Table Name
    protected $table = 'propeller_modell_blaetter';
    // Primary Key
    public $primaryKey = 'id';

    public $sortable = ['name','propeller_modell_blatt_typ_id ','propeller_klasse_design_id ','propeller_modell_kompatibilitaet_id','propeller_vorderkanten_typ_id ','bereichslaenge','updated_at'];

    
    public function propellerForm(){
        return $this->hasMany(PropellerForm::class);
    }  

    public function propellerModellKompatibilitaet(){
        return $this->belongsTo(PropellerModellKompatibilitaet::class);
    }

    public function propellerKlasseDesign(){
        return $this->belongsTo(PropellerKlasseDesign::class);
    }

    public function propellerModellBlattTyp(){
        return $this->belongsTo(PropellerModellBlattTyp::class);
    }
    
    public function propellerDrehrichtung(){
        return $this->belongsTo(PropellerDrehrichtung::class);
    }

    public function propellerDurchmesser(){
        return $this->belongsTo(PropellerDurchmesser::class);
    }
    
    public function propellerVorderkantenTyp(){
        return $this->belongsTo(PropellerVorderkantenTyp::class);
    }

    public function propellerModellBlattLogo(){
        return $this->belongsTo(PropellerModellBlattLogo::class);
    }

    public function propellerFormMatrix(){
        return $this->hasMany(PropellerFormMatrix::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
    
}
