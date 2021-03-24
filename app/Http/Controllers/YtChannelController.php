<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\YtChannel;

class YtChannelController extends Controller
{
    public function index()
    {
      $channels = YtChannel::all();

      //return successful response
      return response()->json(['data' => $channels, 'message' => 'Get YT Channel Succesfully'], 200);
    }
    public function show($id)
    {
      $channel = YtChannel::where('id', $id)->first();

      //return successful response
      return response()->json(['data' => $channel, 'message' => 'Show YT Channel Succesfully'], 200);
    }
}
