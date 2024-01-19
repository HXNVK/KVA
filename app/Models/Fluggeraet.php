<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class Fluggeraet extends Model
{
    use Sortable;
    use SoftDeletes;
    
    //MassAssignment
    protected $guarded = [];
    //Table Name
    protected $table = 'fluggeraete';
    // Primary Key
    public $primaryKey = 'id';

    public $timestamps = true;

    public $sortable = ['name'];


    public function kunde(){
        return $this->belongsTo(Kunde::class);
    }

    public function motorAusrichtung(){
        return $this->belongsTo(MotorAusrichtung::class);
    }

    public function projektZertifizierung(){
        return $this->belongsTo(ProjektZertifizierung::class);
    }

    public function artikel05Distanzscheibe(){
        return $this->belongsTo(Artikel05Distanzscheibe::class,'artikel_05Distanzscheibe_id');
    }

    public function artikel06ASGP(){
        return $this->belongsTo(Artikel06ASGP::class, 'artikel_06ASGP_id');
    }

    public function artikel06SPGP(){
        return $this->belongsTo(Artikel06SPGP::class, 'artikel_06SPGP_id');
    }

    public function artikel06SPKP(){
        return $this->belongsTo(Artikel06SPKP::class, 'artikel_06SPKP_id');
    }



    public function user(){
        return $this->belongsTo(User::class);
    }


}
