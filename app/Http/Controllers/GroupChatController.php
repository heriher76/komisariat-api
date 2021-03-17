<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GroupChat;
use App\UserHasGroup;

class GroupChatController extends Controller
{
    public function index() {
        try {
            $iam = \Auth::user();

            return response()->json(['data' => $iam->groups, 'message' => 'Get Group Chats Succesfully'], 200);
        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => 'Cant Get Group Chats!'], 409);
        }
    }

    public function create(Request $request)
    {
        try {
            $iam = \Auth::user();

            $groupChat = GroupChat::create([
              'name' => $request->input('name'),
              'admin_group' => $iam->id
            ]);

            UserHasGroup::create([
              'id_user' => $iam->id,
              'id_group' => $groupChat->id,
              'is_admin' => 1
            ]);

            return response()->json(['data' => $groupChat, 'message' => 'Create Group Succesfully'], 201);
        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => 'Create Group Chat Failed!'], 409);
        }
    }

    public function add(Request $request, $id)
    {
        try {
            $iam = \Auth::user();
            $groupChat = GroupChat::where('id', $id)->first();
            if($groupChat->admin == null || $groupChat->admin->id != $iam->id) {
                return response()->json(['message' => 'You Are Not Admin Group!'], 409);
            }

            $users = $request->input('users');
            $groupChat->users()->attach($users);

            return response()->json(['data' => $groupChat->users->pluck('id', 'name', 'email'), 'message' => 'Add User Succesfully'], 201);
        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => 'Cannot Add User!'], 409);
        }
    }

    public function leave(Request $request, $id)
    {
        try {
            $iam = \Auth::user();
            $groupChat = UserHasGroup::where('id_group', $id)->where('id_user', $iam->id)->first();

            $groupChat->delete();

            return response()->json(['status' => true, 'message' => 'Leave Succesfully'], 200);
        } catch (\Exception $e) {
            //return error message
            return response()->json(['status' => false, 'message' => 'Cannot Leave!'], 409);
        }
    }

    public function users($id)
    {
        try {
            $groupChat = GroupChat::where('id', $id)->first();

            return response()->json(['data' => $groupChat->users, 'status' => true, 'message' => 'Get Users Group Succesfully'], 200);
        } catch (\Exception $e) {
            //return error message
            return response()->json(['status' => false, 'message' => 'Cannot Get Users!'], 409);
        }
    }
}
