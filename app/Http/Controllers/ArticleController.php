<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;

class ArticleController extends Controller
{
    public function index()
    {
      $articles = Article::all();

      //return successful response
      return response()->json(['articles' => $articles, 'message' => 'Get Articles Succesfully'], 200);
    }
    public function show($id)
    {
      $article = Article::where('id', $id)->first();

      //return successful response
      return response()->json(['article' => $article, 'message' => 'Show Article Succesfully'], 200);
    }
}
