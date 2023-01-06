<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Models\Book;
use App\Services\BookService;
use Illuminate\Http\Request;

class BookController extends Controller
{
    protected $service;
    
    public function __construct( BookService $service )
    {
        $this->service = $service;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $books = $this->service->list($request->all());
        
        return response($books, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreBookRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBookRequest $request)
    {
        $book = $this->service->store($request->all());
        
        return response(['message' => 'Livro cadastrado com sucesso !'], 201);
    }
}
