<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjektGeraeteklasse extends Model
{
    //MassAssignment
    protected $guarded = [];
    //Table Name
    protected $table = 'projekt_geraeteklassen';
    // Primary Key
    public $primaryKey = 'id';
      
    public function blattmodellTyp(){
        return $this->hasMany(BlattmodellTyp::class);
    }  
    
    public function projekt(){
        return $this->hasMany(Projekt::class);
    } 

    public function motor(){
        return $this->hasMany(Motor::class);
    } 
}
