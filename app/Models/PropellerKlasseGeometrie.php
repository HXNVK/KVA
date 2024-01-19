<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropellerKlasseGeometrie extends Model
{
    

    //MassAssignment
    protected $guarded = [];
    //Table Name
    protected $table = 'propeller_klasse_geometrien';
    // Primary Key
    public $primaryKey = 'id';
    



    public function propellerModellBlatt(){
        return $this->hasMany(PropellerModellBlatt::class);
    } 
    
    public function propellerModellWurzel(){
        return $this->hasMany(PropellerModellWurzel::class);
    }

}
