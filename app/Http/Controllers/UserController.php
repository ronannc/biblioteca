<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * @param \App\Http\Requests\UserRequest $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function store( UserRequest $request )
    {
        $data               = $request->all();
        $data[ 'password' ] = Hash::make( $data[ 'password' ] );
        User::create( $data );
        
        return response( [ 'message' => 'Usuario cadastrado com sucesso !' ], 201 );
    }
    
    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function auth( Request $request )
    {
        $user = User::where( 'email', $request->email )->first();
        if ( !$user || !Hash::check( $request->password, $user->password ) ) {
            return response( [ 'message' => 'Dados incorretos' ], 400 );
        }
        
        return response( [ 'token' => $user->createToken( 'doutor-ie' )->plainTextToken ], 200 );
    }
}
