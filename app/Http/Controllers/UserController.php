<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function logout(){
        auth()->logout();
        return 'you are logged out';
    }
    public function showCorrectHomepage(){
        if(auth()->check()){
            return view('homepage-feed');
        }else{
            return view('homepage');
        }
    }
    
    public function login(Request $request){
         $incomingGields = $request->validate(
            [
                'loginusername'=> 'required', 
                'loginpassword' => 'required'
                
            ]        
        );

         if(auth()->attempt(['username'=>$incomingGields['loginusername'] , 'password'=>$incomingGields['loginpassword'] ] )){
            $request->session()->regenerate();
            return 'congrats';
        }else{                                                                                                                                                                                                                                                
            return 'sorry'  ;
            }
    }

    public function register(Request $request){
        $incomingGields = $request->validate(
            [
                'username' => ['required','min:4', 'max:20',Rule::unique('users','username') ],
                'email' => ['required', 'email',Rule::unique('users','email')],
                'password' => ['required', 'min:8' , 'confirmed'],
            ]
        );
        User::create($incomingGields);
        return 'hello world';
    }
    
}

