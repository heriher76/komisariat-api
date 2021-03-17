<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\StructureOrganization;

class StructureOrganizationController extends Controller
{
    public function index()
    {
      $structures = StructureOrganization::all();

      //return successful response
      return response()->json(['structures' => $structures, 'message' => 'Get Structures Succesfully'], 200);
    }
}
