<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropellerDrehrichtung extends Model
{
    //MassAssignment
    protected $guarded = [];
    //Table Name
    protected $table = 'propeller_drehrichtungen';
    // Primary Key
    public $primaryKey = 'id';
    
    public $sortable = ['name'];
    
    public function propellerModellBlatt(){
        return $this->hasMany(PropellerModellBlatt::class);
    }   
     
    public function propellerModellWurzel(){
        return $this->hasMany(PropellerModellWurzel::class);
    }


}
