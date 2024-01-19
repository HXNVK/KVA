<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropellerDurchmesser extends Model
{
    //MassAssignment
    protected $guarded = [];
    //Table Name
    protected $table = 'propeller_durchmesser';
    // Primary Key
    public $primaryKey = 'id';
    

    // public function propellerModellBlatt(){
    //     return $this->hasMany(PropellerModellBlatt::class);
    // }   

}
