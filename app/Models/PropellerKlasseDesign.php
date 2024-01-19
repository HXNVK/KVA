<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropellerKlasseDesign extends Model
{
    

    //MassAssignment
    protected $guarded = [];
    //Table Name
    protected $table = 'propeller_klasse_designs';
    // Primary Key
    public $primaryKey = 'id';
    



    public function propellerModellBlatt(){
        return $this->hasMany(PropellerModellBlatt::class);
    } 

    public function propellerModellBlattTyp(){
        return $this->hasMany(PropellerModellBlattTyp::class);
    }

}
