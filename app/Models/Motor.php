<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class Motor extends Model
{
    use Sortable;
    use SoftDeletes;
    
    //MassAssignment
    protected $guarded = [];
    //Table Name
    protected $table = 'motoren';
    // Primary Key
    public $primaryKey = 'id';

    public $timestamps = true;

    public $sortable = ['id','name'];


    public function motorArbeitsweise(){
        return $this->belongsTo(MotorArbeitsweise::class);
    }   

    public function projektGeraeteklasse(){
        return $this->belongsTo(ProjektGeraeteklasse::class);
    } 

    public function motorDrehrichtung(){
        return $this->belongsTo(MotorDrehrichtung::class);
    }

    public function motorStatus(){
        return $this->belongsTo(MotorStatus::class);
    }  

    public function motorTyp(){
        return $this->belongsTo(MotorTyp::class);
    }  

    public function motorKupplung(){
        return $this->belongsTo(MotorKupplung::class);
    }

    public function motorKuehlung(){
        return $this->belongsTo(MotorKuehlung::class);
    }

    public function kunde(){
        return $this->belongsTo(Kunde::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function projekt(){
        return $this->hasMany(Projekt::class);
    }

    public function motorGetriebe(){
        return $this->hasMany(MotorGetriebe::class);
    }

    public function motorFlansch(){
        return $this->hasMany(MotorFlansch::class);
    }
    



}