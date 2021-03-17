<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\InfoTraining;

class TrainingController extends Controller
{
    public function index()
    {
      $info = InfoTraining::all();

      //return successful response
      return response()->json(['info' => $info, 'message' => 'Get Info Training Succesfully'], 200);
    }
    public function show($id)
    {
      $info = InfoTraining::where('id', $id)->first();

      //return successful response
      return response()->json(['info' => $info, 'message' => 'Show Info Training Succesfully'], 200);
    }
}
