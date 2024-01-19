<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MotorGetriebeArt extends Model
{
        //MassAssignment
        protected $guarded = [];
        //Table Name
        protected $table = 'motor_getriebe_arten';
        // Primary Key
        public $primaryKey = 'id';
    
        public $timestamps = true;
        
}
