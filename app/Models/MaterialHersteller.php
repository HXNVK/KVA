<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class MaterialHersteller extends Model
{
    use Sortable;

    //MassAssignment
    protected $guarded = [];
    //Table Name
    protected $table = 'material_hersteller';
    // Primary Key
    public $primaryKey = 'id';
    
    public $sortable = ['name'];
    
    
    public function materialHalbzeug(){
        return $this->hasMany(MaterialHalbzeug::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

}
