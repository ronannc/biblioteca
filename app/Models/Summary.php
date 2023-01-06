<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Summary extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'indices';
    protected $primaryKey = 'id';
    protected $fillable = [
      'livro_id'  ,
      'indice_pai_id',
      'titulo',
      'pagina'
    ];
    
    public function summary_father(){
        return $this->belongsTo(Summary::class, 'indice_pai_id', 'id');
    }
}
