<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use Kyslik\ColumnSortable\Sortable;

class MaterialGruppe extends Model
{
    
    //use Sortable;
    
    //MassAssignment
    protected $guarded = [];
    //Table Name
    protected $table = 'material_gruppen';
    // Primary Key
    public $primaryKey = 'id';

    public $timestamps = true;

    public $sortable = ['name'];
    
    /**
     * Get the hersteller for this model.
     *
     * @return App\Models\Hersteller
     */



}
