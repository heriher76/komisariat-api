<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ebook;

class EbookController extends Controller
{
    public function index()
    {
      $ebook = Ebook::all();

      //return successful response
      return response()->json(['ebook' => $ebook, 'message' => 'Get Ebooks Succesfully'], 200);
    }
    public function show($id)
    {
      $ebook = Ebook::where('id', $id)->first();

      //return successful response
      return response()->json(['ebook' => $ebook, 'message' => 'Show Ebook Succesfully'], 200);
    }
}
