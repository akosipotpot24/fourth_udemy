<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExampleController extends Controller
{
    public function homepage (){
        
        $ouraName = 'fourth';

        $animals = ['Meowsalot','barksalot','hakdog'];

        return view('homepage', ['allAnimals'=> $animals, 'name'=> $ouraName,'catsname'=>'meowsalot']);
    }
    public function aboutPage(){
        return view('single-post');
    }
    public function matrix(){
        return view('matrix');
    }
}
