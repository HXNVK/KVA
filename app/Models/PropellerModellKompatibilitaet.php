<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class PropellerModellKompatibilitaet extends Model
{
    use Sortable;
    
    //MassAssignment
    protected $guarded = [];
    //Table Name
    protected $table = 'propeller_modell_kompatibilitaeten';
    // Primary Key
    public $primaryKey = 'id';
    
    public $sortable = ['name'];  

    public function propellerModellBlatt(){
        return $this->hasMany(PropellerModellBlatt::class);
    } 
    
    public function propellerModellWurzel(){
        return $this->hasMany(PropellerModellWurzel::class);
    }

    public function propellerModellBlattTyp(){
        return $this->hasMany(PropellerModellBlattTyp::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
    
}
