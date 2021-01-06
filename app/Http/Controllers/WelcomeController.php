<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Article;
class WelcomeController extends Controller
{
    //
    public function index(){
        $articles=Article::inRandomOrder()->orderBy('id','DESC')->paginate();
        return view('welcome', compact('articles'));
    }
}
