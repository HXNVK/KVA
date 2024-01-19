<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class PropellerStepCode extends Model
{
    use Sortable;
    use SoftDeletes;
    
    //MassAssignment
    protected $guarded = [];
    //Table Name
    protected $table = 'propeller_step_code';
    // Primary Key
    public $primaryKey = 'id';

    public $timestamps = true;

    public $sortable = ['name','created_at','updated_at'];
    

    public function propellerModellBlatt(){
        return $this->belongsTo(PropellerModellBlatt::class);
    }   
    
    public function user(){
        return $this->belongsTo(User::class);
    }

}
