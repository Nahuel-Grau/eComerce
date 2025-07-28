<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{ 
    public function register(Request $request){
        try {
        $validated = $request->validate([
        'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            ]);
        $validated['password'] = Hash::make($validated['password']);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            
        ]);
              
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
        'message'=> 'registrado con éxito',
        'access_token' => $token,
        
        ], 200);
        } catch (\Exception $e) {
        return response()->json([
            'message' => 'Datos invalidos',
        
        ], 422);
        }}


    public function login(Request $request){
        try {
            $credentials = [
                'email' => $request->email,
                'password' => $request->password
            ];

            if (Auth::attempt($credentials)) {
                
                $token = Auth::user()->createToken('grecia_token')->plainTextToken;
                session()->put('token', $token);
                
                return response()->json([
                    'message' => 'logueado con éxito',
                    'acces_token' =>$token,
                ],200);
            }else{
                return response()->json([
                'message' => 'Credenciales invalidas',
        
        ], 401);
            }
        }catch (\Exception $e) {
             return response()->json([
            'message' => $e,
        
        ], 500);
        }
    }   

    public function logout(Request $request){
        try {
            $user = $request->user();
            if($user && $user->CurrentAccessToken()){
                $user->CurrentAccessToken()->delete();

                return response()->json([
                'message' => 'Logout con éxito'
            ],200);
            }else{

            return response()->json([
            'message' => 'Token no encontrado o ya revocado'
                ], 400);    
            }


        } catch (\Exception $e) {
          return response()->json([
            'message'=> 'Error al cerrar sessión'
          ],500);
        }
       

 }
}