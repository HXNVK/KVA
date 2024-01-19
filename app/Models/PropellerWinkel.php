<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropellerWinkel extends Model
{
    //MassAssignment
    protected $guarded = [];
    //Table Name
    protected $table = 'propeller_winkel';
    // Primary Key
    public $primaryKey = 'id';
    

    // public function propellerModellBlatt(){
    //     return $this->hasMany(PropellerModellBlatt::class);
    // }   

}
