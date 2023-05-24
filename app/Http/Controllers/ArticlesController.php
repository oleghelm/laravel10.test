<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\User;
use App\Services\SubscriptionService;

class ArticlesController extends Controller
{
    public function list(Request $req){
        $articles = Article::paginate(20);
        return response()->json(['articles' => $articles->toArray()]);
    }
    
    public function detail(Article $article){
        return response()->json(['article' => $article->toArray()]);
    }
    
    public function new(){
        $canAdd = SubscriptionService::canCurrentUserAddArticle();
        if($canAdd === true){
            $resp['success'] = true;
        } else {
            $resp['error'] = $canAdd;
        }
        return response()->json($resp);
    }
    
    public function save(Request $req){
        $user = Auth::user();
        $canAdd = SubscriptionService::canCurrentUserAddArticle();
        
        if($canAdd === true){
            $article = new Article();
            $article->name = $req->name;
            $article->user_id = $user->id;
            $article->text = $req->text;
            $article->save();
            
            $resp['success'] = true;
        } else {
            $resp['error'] = $canAdd;
        }
                
        return response()->json($resp);
    }
}
