<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\User as UserResource;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::orderBy('created_at')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = New User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->birthday = $request->input('birthday');
        date('d-m-Y', strtotime($user->birthday));
        if( $user->save() ){
            return new UserResource( $user );
          }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   
        $userId = User::find($id);
        if(is_null($userId)) {
            return response()->json([
                'message'   => 'Usuário não econtrado',
            ], 400);
        } else {
            return $userId;
        }
                
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Int $id)
    {
        $userId = User::find($id);
        if(is_null($userId)) {
            return response()->json([
                'message'   => 'Usuário não econtrado',
            ], 400);
        } else {
            $userId->delete();
            return response()->json([
                'message'   => 'Usuário deletado com sucesso',
            ], 200);
        }
    }
}
