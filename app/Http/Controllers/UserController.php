<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
//use App\Services\BookService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
//    protected $service;
//
//    public function __construct( BookService $service )
//    {
//        $this->service = $service;
//    }
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreBookRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $data = $request->all();
        $data['password'] = Hash::make($data['password']);
        User::create($data);
        return response(['message' => 'Usuario cadastrado com sucesso !'], 201);
    }
    
    public function auth(Request $request){
        $user = User::where('email', $request->email)->first();
    
        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                                                        'email' => ['The provided credentials are incorrect.'],
                                                    ]);
        }
    
        return response(['token' => $user->createToken('doutor-ie')->plainTextToken], 200) ;
    }
}
