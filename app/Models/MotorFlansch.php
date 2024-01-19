<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class MotorFlansch extends Model
{
    use Sortable;
    
    //MassAssignment
    protected $guarded = [];
    //Table Name
    protected $table = 'motor_flansche';
    // Primary Key
    public $primaryKey = 'id';

    public $timestamps = true;

    public $sortable = ['name'];


    public function projekt(){
        return $this->hasMany(Projekt::class);
    }
    
    public function motor(){
        return $this->belongsTo(Motor::class);
    }
    
    public function artikel07AP(){
        return $this->belongsTo(Artikel07AP::class, 'artikel_07AP_id');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}