<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\Article;

class ArticleService {
    
    public static function create(Request $req){
        
        $user = \Auth::user();
        
        $article = new Article();
        $article->name = $req->name;
        $article->user_id = $user->id;
        $article->text = $req->text;
        $article->save();
        
        return true;
    }
    
}