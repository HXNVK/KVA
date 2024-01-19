<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class Projekt extends Model
{
    use Sortable;
    //use SoftDeletes;
    
    //MassAssignment
    protected $guarded = [];
    //Table Name
    protected $table = 'projekte';
    // Primary Key
    public $primaryKey = 'id';

    public $timestamps = true;

    public $sortable = ['name','mtow'];


    public function projektGeraeteklasse(){
        return $this->belongsTo(ProjektGeraeteklasse::class);
    }

    public function projektKategorie(){
        return $this->belongsTo(ProjektKategorie::class);
    }

    public function projektStatus(){
        return $this->belongsTo(ProjektStatus::class);
    }

    public function projektTriebwerksart(){
        return $this->belongsTo(ProjektTriebwerksart::class);
    }

    public function projektTyp(){
        return $this->belongsTo(ProjektTyp::class);
    }

    public function projektZertifizierung(){
        return $this->belongsTo(ProjektZertifizierung::class);
    }

    public function kunde(){
        return $this->belongsTo(Kunde::class);
    }

    public function motor(){
        return $this->belongsTo(Motor::class, 'motor_id');
    }

    // public function motorGetriebe(){
    //     return $this->belongsTo(MotorGetriebe::class);
    // }

    public function motorFlansch(){
        return $this->belongsTo(MotorFlansch::class);
    }

    public function motorAusrichtung(){
        return $this->belongsTo(MotorAusrichtung::class);
    }

    public function fluggeraet(){
        return $this->belongsTo(Fluggeraet::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }


}
