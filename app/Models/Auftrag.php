<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Auftrag extends Model
{
    use Sortable;
    use SoftDeletes;

    //MassAssignment
    protected $guarded = [];
    //Table Name
    protected $table = 'auftraege';
    // Primary Key
    public $primaryKey = 'id';

    public $timestamps = true;

    public $sortable = ['kundeMatchcode','propeller','ausfuehrung','farbe','projekt', 'dringlichkeit','auftrag_status_id','created_at', 'updated_at'];


    public function auftragStatus(){
        return $this->belongsTo(AuftragStatus::class);
    }

    public function auftragTyp(){
        return $this->belongsTo(AuftragTyp::class);
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
    

    public function createdAtUser(){
        return $this->belongsTo(User::class, 'createdAt_user_id');
    }

}
