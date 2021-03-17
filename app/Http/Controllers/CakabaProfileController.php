<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Profile;

class CakabaProfileController extends Controller
{
    public function index()
    {
      $profile = Profile::first();

      //return successful response
      return response()->json(['cakaba-profile' => $profile, 'message' => 'Get Profile Succesfully'], 200);
    }
}
