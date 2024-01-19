<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class PropellerStepCodeBlattBlock extends Model
{
    use Sortable;
    //use SoftDeletes;

    //MassAssignment
    protected $guarded = [];
    //Table Name
    protected $table = 'propeller_step_code_blattBloecke';
    // Primary Key
    public $primaryKey = 'id';

    public $timestamps = true;


    public function user(){
        return $this->belongsTo(User::class);
    }


}