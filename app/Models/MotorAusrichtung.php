<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class MotorAusrichtung extends Model
{
    use Sortable;
    
    //MassAssignment
    protected $guarded = [];
    //Table Name
    protected $table = 'motor_ausrichtungen';
    // Primary Key
    public $primaryKey = 'id';

    public $timestamps = true;

    public $sortable = ['name'];



}