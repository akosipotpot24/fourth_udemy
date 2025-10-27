<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Follow;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;

class UserController extends Controller
{

    public function storeAvatar(Request $request){
        $request->validate([
            'avatar'=>'required|image|max:3000'
        ]);
        $user = auth()->user();
        $filename  = $user->id . "-" . uniqid() . ".jpg";
        $manager = new ImageManager(new Driver());
        $image = $manager->read($request->file('avatar'));
        $imgData = $image->cover(1080,1080)->toJpeg();

        Storage::disk('public')->put('avatars/' . $filename,$imgData);

        $oldAvatar = $user->avatar;
      

        $user->avatar = $filename;
        $user->save();

          if($oldAvatar != "/fallback-avatar.png"){
            Storage::disk('public')->delete(str_replace("/storage/", "", $oldAvatar) );
        }
        
        return back()->with('success', 'Congrats on the new avatar.');
    }
    public function showAvatarForm(){
        return view('avatar-form');
    }

    public function profile(User $user){
        $currentlyFollowing = 0;
        if(auth()->check()){
            $currentlyFollowing = Follow::where([['user_id','=',auth()->user()->id], ['followeduser', '=' ,$user->id]])->count();
        }
      
        return view('profile-posts',['currentlyFollowing'=>$currentlyFollowing ,'avatar'=> $user->avatar, 'username'=>$user->username,'posts'=>$user->posts()->latest()->get(),'postCount' => $user->posts()->count()]);
    }

    public function logout(){
        auth()->logout();
        return redirect('/')->with( 'success' , 'You have Succesfully logged out.' );
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
            return redirect('/')->with( 'success' , 'You have Succesfully logged in.' );
        }else{
            return redirect('/')->with( 'failure' , 'Invalid Login.' ); ;
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
       $user= User::create($incomingGields);
        auth()->login($user);
        return redirect('/')->with( 'success' , 'thank you for creating account.' );
    }

}

