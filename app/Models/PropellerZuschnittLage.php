<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropellerZuschnittLage extends Model
{
    

    //MassAssignment
    protected $guarded = [];
    //Table Name
    protected $table = 'propeller_zuschnitt_lagen';
    // Primary Key
    public $primaryKey = 'id';

    
    public function material(){
        return $this->belongsTo(Material::class, 'material_id');
    }

    public function propellerZuschnittSchablone(){
        return $this->belongsTo(PropellerZuschnittSchablone::class, 'propeller_zuschnitt_schablone_id');
    }

    public function propellerZuschnitt(){
        return $this->belongsTo(PropellerZuschnitt::class, 'propeller_zuschnitt_id');
    }



}
