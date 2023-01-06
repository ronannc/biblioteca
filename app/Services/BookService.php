<?php

namespace App\Services;

use App\Models\Book;
use App\Repositories\Contracts\BookRepository;

class BookService
{
    protected $repository;
    
    public function __construct(
        BookRepository $repository,
    ) {
        $this->repository = $repository;
    }
    
    public function list( $filters )
    {
        $books = $this->repository->filter( $filters )->get();
        $books->transform(function($item){
            $item['summaries'] = array_values( $this->groupSummaries($item->summary->sortByDESC('id')->values()->keyBy('id')->toArray()));
            unset($item['summary']);
            return $item;
        });
        
        return $books->toArray();
    }
    
    private function groupSummaries($summaries)
    {
        foreach ($summaries as $key => $summary){
            if ( !isset( $summaries[ $key ][ 'subindices' ] ) ) {
                $summaries[ $key ][ 'subindices' ] = [];
            }
            if ( $summary[ 'indice_pai_id' ] ) {
                $summaries[ $summaries[ $key ][ 'indice_pai_id' ] ][ 'subindices' ][] = $summaries[ $key ];
                unset( $summaries[ $key ] );
            }
        }
        return collect($summaries)->sortBy('id')->toArray();
    }
    
    /**
     * Funcao que salva o livro e seus indices
     *
     * @param $data
     *
     * @return \App\Models\Book|array
     */
    public function store( $data, $user )
    {
        /** @var Book $book */
        $book = Book::create( [ 'titulo' => $data[ 'titulo' ], 'usuario_publicador_id' => $user->id ] );
        $this->saveSummary( $book, $data[ 'indices' ] );
        
        return $book;
    }
    
    /**
     * Funcao recursiva para salvar indices dos livros
     *
     * @param \App\Models\Book $book
     * @param                  $summaries
     * @param                  $summary_id
     *
     * @return void
     */
    private function saveSummary( Book $book, $summaries, $summary_id = null ): void
    {
        foreach ( $summaries as $summary ) {
            $summary[ 'indice_pai_id' ] = $summary_id;
            $objSummary                 = $book->summary()->create( $summary );
            if ( isset( $summary[ 'subindices' ] ) and !empty( $summary[ 'subindices' ] ) ) {
                $this->saveSummary( $book, $summary[ 'subindices' ], $objSummary->id );
            }
        }
    }
}
