<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Material extends Model
{
    
    use Sortable;
    
    //MassAssignment
    protected $guarded = [];
    //Table Name
    protected $table = 'materialien';
    // Primary Key
    public $primaryKey = 'id';

    public $timestamps = true;

    public $sortable = ['name'];
    
    /**
     * Get the hersteller for this model.
     *
     * @return App\Models\Hersteller
     */
    public function materialHersteller()
    {
        return $this->belongsTo(MaterialHersteller::class);
    }

    public function materialGruppe()
    {
        return $this->belongsTo(MaterialGruppe::class);
    }

    public function materialTyp()
    {
        return $this->belongsTo(MaterialTyp::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }


}
