<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use Kyslik\ColumnSortable\Sortable;

class PropellerAufkleber extends Model
{

    
    //MassAssignment
    protected $guarded = [];
    //Table Name
    protected $table = 'propeller_aufkleber';
    // Primary Key
    public $primaryKey = 'id';

    public function projektPropeller(){
        return $this->hasMany(ProjektPropeller::class);
    }
   

}