<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PersonalChat;

class PersonalChatController extends Controller
{
    public function index() {
        try {
            $iam = \Auth::user();

            return response()->json(['data' => $iam->personalChats, 'message' => 'Get Personal Chats Succesfully'], 200);
        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => 'Cant Get PersonalChats!'], 409);
        }
    }
}
