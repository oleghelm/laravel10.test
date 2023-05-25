<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Services\ArticleService;

class ArticlesController extends Controller {

    public function list(Request $req) {
        $articles = Article::paginate(20);
        return response()->json(['articles' => $articles->toArray()]);
    }

    public function detail(Article $article) {
        return response()->json(['article' => $article->toArray()]);
    }

    public function new() {
        $this->authorize('create', Article::class);
        return response()->json($resp);
    }

    public function save(Request $req) {
        $this->authorize('create', Article::class);
        $resp['success'] = ArticleService::create($req);
        return response()->json($resp);
    }

}
