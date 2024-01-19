<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class MotorStatus extends Model
{
    use Sortable;
    
    //MassAssignment
    protected $guarded = [];
    //Table Name
    protected $table = 'motor_status';
    // Primary Key
    public $primaryKey = 'id';

    public $timestamps = true;

    public $sortable = ['name'];


    public function motor(){
        return $this->hasMany(Motor::class);
    }
}