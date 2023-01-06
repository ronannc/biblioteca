<?php

namespace App\Repositories;

use App\Models\Book;
use App\Repositories\Contracts\BookRepository;

class EloquentBookRepository extends AbstractEloquentRepository implements BookRepository
{
    public function filter( $filter )
    {
        return $this->model->with( 'summary' )->where( function ( $query ) use ( $filter ) {
            if ( isset( $filter[ 'titulo' ] ) and $filter[ 'titulo' ] ) {
                $query->where( 'titulo', $filter[ 'titulo' ] );
            }
            if ( isset( $filter[ 'titulo_do_indice' ] ) and $filter[ 'titulo_do_indice' ] ) {
                $query->whereHas( 'summary', function ( $subQuery ) use ( $filter ) {
                    $subQuery->where( 'indices.titulo', $filter[ 'titulo_do_indice' ] );
                } );
            }
        } );
    }
}
