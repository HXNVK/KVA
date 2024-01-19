<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use Kyslik\ColumnSortable\Sortable;

class PropellerModellBlattLogo extends Model
{
    //use Sortable;

    //MassAssignment
    protected $guarded = [];
    //Table Name
    protected $table = 'propeller_modell_blatt_logos';
    // Primary Key
    public $primaryKey = 'id';

    public $sortable = ['text'];  
    
    
    public function propellerModellBlatt(){
        return $this->hasMany(PropellerModellBlatt::class);
    } 
    
}
