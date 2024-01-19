<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;

class ProjektPropeller extends Model
{
    
    //use SoftDeletes;

    //MassAssignment
    protected $guarded = [];
    //Table Name
    protected $table = 'projekt_propeller';
    // Primary Key
    public $primaryKey = 'id';

    public $timestamps = true;

    public $sortable = ['name','projekt_id'];


    public function projekt(){
        return $this->belongsTo(Projekt::class, 'projekt_id');
    }  

    public function propeller(){
        return $this->belongsTo(Propeller::class, 'propeller_id');
    }

    public function artikel03Ausfuehrung(){
        return $this->belongsTo(Artikel03Ausfuehrung::class, 'artikel_03Ausfuehrung_id');
    }

    public function artikel03Farbe(){
        return $this->belongsTo(Artikel03Farbe::class, 'artikel_03Farbe_id');
    }

    public function artikel03Kantenschutz(){
        return $this->belongsTo(Artikel03Kantenschutz::class, 'artikel_03Kantenschutz_id');
    }

    public function propellerAufkleber(){
        return $this->belongsTo(PropellerAufkleber::class, 'propeller_aufkleber_id');
    }

    public function propellerDurchmesser(){
        return $this->belongsTo(PropellerDurchmesser::class, 'propellerDurchmesser_id');
    }

    public function motorGetriebe(){
        return $this->belongsTo(MotorGetriebe::class, 'motor_getriebe_id');
    }


}
