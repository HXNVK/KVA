<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class AuftragPropellernummer extends Model
{

    //MassAssignment
    protected $guarded = [];
    //Table Name
    protected $table = 'auftrag_propellernummern';
    // Primary Key
    public $primaryKey = 'id';

    public $timestamps = true;


}
