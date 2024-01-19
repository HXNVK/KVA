<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class PropellerModellBlattTyp extends Model
{
    use Sortable;
    use SoftDeletes;

    //MassAssignment
    protected $guarded = [];
    //Table Name
    protected $table = 'propeller_modell_blatt_typen';
    // Primary Key
    public $primaryKey = 'id';
  
    public $sortable = ['name','name_alt'];
    
    public function propellerModellBlatt(){
        return $this->hasMany(PropellerModellBlatt::class);
    } 

    public function propellerKlasseDesign(){
        return $this->belongsTo(PropellerKlasseDesign::class);
    }
    
    public function propellerModellKompatibilitaet(){
        return $this->belongsTo(PropellerModellKompatibilitaet::class);
    }

    public function projektGeraeteklasse(){
        return $this->belongsTo(ProjektGeraeteklasse::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

}
