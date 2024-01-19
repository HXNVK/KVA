<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class PropellerZuschnitt extends Model
{

    use Sortable;

    //MassAssignment
    protected $guarded = [];
    //Table Name
    protected $table = 'propeller_zuschnitte';
    // Primary Key
    public $primaryKey = 'id';
    
    public $sortable = ['name'];

    public function propellerModellKompatibilitaet(){
        return $this->belongsTo(PropellerModellKompatibilitaet::class);
    }

    public function propellerKlasseGeometrie(){
        return $this->belongsTo(PropellerKlasseGeometrie::class,'propellerKlasseGeometrie_id');
    }

    public function artikel03Ausfuehrung(){
        return $this->belongsTo(Artikel03Ausfuehrung::class,'propellerAusfuehrung_id');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

}
