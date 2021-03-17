<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Events\ChatSubmitted;
use App\GroupChat;
use App\PersonalChat;

class ChatsController extends Controller
{
    public function groupFetchMessages($id)
    {
        try {
            $groupChat = GroupChat::where('id', $id)->first();
            $messages = $groupChat->messages ?? [];
            //return successful response
            return response()->json(['messages' => $messages, 'message' => 'Group Messages Get Succesfully'], 200);
        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => 'Cannot Get Messages!'], 409);
        }
    }

    public function groupSendMessage(Request $request, $id)
    {
        //validate incoming request
        $this->validate($request, [
            'message' => 'required|string'
        ]);

        $iam = Auth::user();
        $pushdata['message'] = $request->input('message');

        $registration_ids = $this->getGroupRegistrationId($id);

        $fields = array(
            'registration_ids' => $registration_ids,
            'data' => $pushdata,
            'format' => 'group'
        );

        $pushNotif = $this->sendGroupPushNotification($fields);

        try {
            $message = Message::create([
              'message' => $request->input('message'),
              'id_user' => $iam->id,
              'id_group' => $id
            ]);

            //return successful response
            return response()->json(['messages' => $message, 'message' => 'Send Group Message Succesfully'], 201);
        } catch (\Exception $e) {printf($e);
            //return error message
            return response()->json(['message' => 'Send Message Failed!'], 409);
        }
    }

    private function getGroupRegistrationId($id)
    {
        $groupChatTokens = GroupChat::where('id', $id)->first();

        return $groupChatTokens->users->pluck('gcmtoken');
    }

    private function sendGroupPushNotification($fields){
        $url = 'https://fcm.googleapis.com/fcm/send';

        $headers = array(
            'Authorization: key=' . env('GOOGLE_FIREBASE_API_KEY', null),
            'Content-Type: application/json'
        );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);

        return $result;
    }

    public function groupDeleteChat($id)
    {
        try {
            $iam = \Auth::user();
            $groupChat = GroupChat::where('id', $id)->first();
            if($groupChat->admin == null || $groupChat->admin->id != $iam->id) {
                return response()->json(['message' => 'You Are Not Admin Group!'], 409);
            }

            $groupChat->delete();

            return response()->json(['status' => true, 'message' => 'Group Deleted Succesfully'], 200);
        } catch (\Exception $e) {
            //return error message
            return response()->json(['status' => false, 'message' => 'Cannot Delete!'], 409);
        }
    }

/////////////////////////////////////////////////////////////// PERSONAL

    public function personalFetchMessages($id)
    {
        try {
            $iam = \Auth::user();
            $personalChat = PersonalChat::where('id_user', $iam->id)->where('id_receiver', $id)->first();
            $messages = $personalChat->messages ?? [];
            //return successful response
            return response()->json(['messages' => $messages, 'message' => 'Group Messages Get Succesfully'], 200);
        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => 'Cannot Get Messages!'], 409);
        }
    }

    public function personalSendMessage(Request $request, $id)
    {
        //validate incoming request
        $this->validate($request, [
            'message' => 'required|string'
        ]);

        $iam = Auth::user();
        $pushdata['message'] = $request->input('message');

        $registration_ids = $this->getPersonalRegistrationId($id);

        $fields = array(
            'registration_ids' => $registration_ids,
            'data' => $pushdata,
            'format' => 'personal'
        );

        $pushNotif = $this->sendPersonalPushNotification($fields);

        try {
            $hasPersonalChat = PersonalChat::where('id_receiver', $id)->where('id_user', $iam->id)->first();
            if($hasPersonalChat == null) {
              $personalChat = PersonalChat::create([
                'id_user' => $iam->id,
                'id_receiver' => $id
              ]);
            }
            $idPersonalChat = $hasPersonalChat->id ?? $personalChat->id;
            $message = Message::create([
              'message' => $request->input('message'),
              'id_user' => $iam->id,
              'id_personal' => $idPersonalChat
            ]);

            //return successful response
            return response()->json(['messages' => $message, 'message' => 'Send Personal Message Succesfully'], 201);
        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => 'Send Message Failed!'], 409);
        }
    }

    private function getPersonalRegistrationId($id)
    {
        $personalChatTokens = User::where('id', $id)->first();

        return $personalChatTokens->gcmtoken;
    }

    private function sendPersonalPushNotification($fields){
        $url = 'https://fcm.googleapis.com/fcm/send';

        $headers = array(
            'Authorization: key=' . env('GOOGLE_FIREBASE_API_KEY', null),
            'Content-Type: application/json'
        );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);

        return $result;
    }

    public function personalDeleteChat($id)
    {
        try {
            $iam = \Auth::user();
            $personalChat = PersonalChat::where('id_user', $iam->id)->where('id_receiver', $id)->first();

            $personalChat->delete();

            return response()->json(['status' => true, 'message' => 'Deleted Succesfully'], 200);
        } catch (\Exception $e) {
            //return error message
            return response()->json(['status' => false, 'message' => 'Cannot Delete!'], 409);
        }
    }
}
