<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class PropellerForm extends Model
{
    use Sortable;
    use SoftDeletes;
    
    //MassAssignment
    protected $guarded = [];
    //Table Name
    protected $table = 'propeller_formen';
    // Primary Key
    public $primaryKey = 'id';

    public $timestamps = true;

    public $sortable = ['name', 'name_kurz','propeller_modell_blatt_id','winkel','propeller_modell_wurzel_id','created_at','updated_at'];
    

    public function propellerModellBlatt(){
        return $this->belongsTo(PropellerModellBlatt::class);
    }   

    public function propellerModellWurzel(){
        return $this->belongsTo(PropellerModellWurzel::class);
    }

    public function artikel(){
        return $this->hasMany(Artikel::class);
    }
    
    public function user(){
        return $this->belongsTo(User::class);
    }

}
