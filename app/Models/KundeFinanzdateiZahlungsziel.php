<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class KundeFinanzdateiZahlungsziel extends Model
{
    use Sortable;
    
    //MassAssignment
    protected $guarded = [];
    //Table Name
    protected $table = 'kunde_finanzdatei_zahlungsziele';
    // Primary Key
    public $primaryKey = 'id';

    public $timestamps = true;

    public $sortable = ['name'];

    public function kundeFinanzdatei(){
        return $this->hasMany(KundeFinanzdatei::class);
    }  

}
