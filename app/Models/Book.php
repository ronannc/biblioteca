<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table      = 'livros';
    protected $primaryKey = 'id';
    protected $fillable   = [
        'usuario_publicador_id',
        'titulo'
    ];
    protected $attributes = [
        'usuario_publicador_id' => 2
    ];
    
    /**
     * Retorna o usuario criador do livro
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user_publish(): BelongsTo
    {
        return $this->belongsTo( User::class, 'usuario_publicador_id', 'id' );
    }
    
    /**
     * Retorna todos os sumarios do livro
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function summary(): HasMany
    {
        return $this->hasMany( Summary::class, 'livro_id', 'id' );
    }
    

}
