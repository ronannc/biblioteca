<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

abstract class AbstractEloquentRepository implements BaseRepository
{
    /**
     * Instance that extends Illuminate\Database\Eloquent\Model
     *
     * @var Model
     */
    protected $model;
    
    
    /**
     * Constructor
     *
     * @param Model $model
     */
    public function __construct( Model $model )
    {
        $this->model        = $model;
    }
}
