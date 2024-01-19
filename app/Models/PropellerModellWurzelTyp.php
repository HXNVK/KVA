<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropellerModellWurzelTyp extends Model
{
    //MassAssignment
    protected $guarded = [];
    //Table Name
    protected $table = 'propeller_modell_wurzel_typen';
    // Primary Key
    public $primaryKey = 'id';
    
     
    public function propellerModellWurzel(){
        return $this->hasMany(PropellerModellWurzel::class);
    }
}
