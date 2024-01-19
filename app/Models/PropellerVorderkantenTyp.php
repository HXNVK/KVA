<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class PropellerVorderkantenTyp extends Model
{
    use Sortable;

    //MassAssignment
    protected $guarded = [];
    //Table Name
    protected $table = 'propeller_vorderkanten_typen';
    // Primary Key
    public $primaryKey = 'id';

    public $sortable = ['text'];  
    
    
    public function propellerModellBlatt(){
        return $this->hasMany(PropellerModellBlatt::class);
    }   

}
