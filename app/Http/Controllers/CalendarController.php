<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Calendar;

class CalendarController extends Controller
{
    public function index()
    {
      $calendars = Calendar::all();

      //return successful response
      return response()->json(['calendars' => $calendars, 'message' => 'Get Calendars Succesfully'], 200);
    }
    public function show($id)
    {
      $calendar = Calendar::where('id', $id)->first();

      //return successful response
      return response()->json(['calendar' => $calendar, 'message' => 'Show Calendar Succesfully'], 200);
    }
}
