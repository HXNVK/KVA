<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class AuftragTyp extends Model
{
    use Sortable;

    //MassAssignment
    protected $guarded = [];
    //Table Name
    protected $table = 'auftrag_typen';
    // Primary Key
    public $primaryKey = 'id';

    public $timestamps = true;

    public $sortable = ['name'];


}
