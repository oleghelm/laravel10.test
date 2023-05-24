<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Services\SubscriptionService;

class ArticlesController extends Controller
{
    public function list(Request $req){
        $articles = Article::paginate(20);
        
        return view('articles/list', compact('articles'));
    }
    
    public function detail(Article $article){
        
        return view('articles/detail', compact('article'));
    }
    
    public function new(){
        $user = Auth::user();
        $subscription = SubscriptionService::getUserSubscription($user);
        if($subscription && $subscription->articles_left > 0){
            return view('articles/new');
        } else {
            abort(403);
        }
    }
    
    public function save(Request $req){
        $user = Auth::user();
        $subscription = SubscriptionService::getUserSubscription($user);
        if($subscription && $subscription->articles_left > 0){
            $article = new Article();
            $article->name = $req->name;
            $article->user_id = $user->id;
            $article->text = $req->text;
            $article->save();
            return redirect(route('articles.list'));
        } else {
            abort(403);
        }
    }
}
