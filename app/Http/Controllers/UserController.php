<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Str;
use Carbon\Carbon;

class UserController extends Controller
{
     /**
     * Instantiate a new UserController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Get the authenticated User.
     *
     * @return Response
     */
    public function profile()
    {
        return response()->json(['user' => Auth::user()], 200);
    }

    /**
     * Get all User.
     *
     * @return Response
     */
    public function allUsers()
    {
        $users = User::all();

        return response()->json(['data' =>  $users], 200);
    }

    /**
     * Get one user.
     *
     * @return Response
     */
    public function singleUser($id)
    {
        try {
            $user = User::findOrFail($id);

            return response()->json(['user' => $user], 200);

        } catch (\Exception $e) {

            return response()->json(['message' => 'User Not Found!'], 404);
        }
    }

    public function searchUser($name)
    {
        try {
            $users = User::where('name', 'LIKE', "%$name%")->get();

            return response()->json(['users' => $users], 200);

        } catch (\Exception $e) {

            return response()->json(['message' => 'User Not Found!'], 404);
        }
    }

    public function editProfile(Request $request)
    {
        try {
            $iam = Auth::user();

            $user = User::where('id', $iam->id)->first();
            $user->update([
              'name' => $request->input('name') ?? $user->name,
              'hp' => $request->input('hp') ?? $user->hp,
              'email' => $request->input('email') ?? $user->email,
              'address' => $request->input('address') ?? $user->address,
              'department' => $request->input('department') ?? $user->department,
              'komisariat' => $request->input('komisariat') ?? $user->komisariat,
              'sex' => $request->input('sex') ?? $user->sex,
              'age' => $request->input('age') ?? $user->age,
              'jenjang_training' => $request->input('jenjang_training') ?? $user->jenjang_training,
              'pengalaman_organisasi' => $request->input('pengalaman_organisasi') ?? $user->pengalaman_organisasi,
              'linkedin' => $request->input('linkedin') ?? $user->linkedin,
              'instagram' => $request->input('instagram') ?? $user->instagram,
              'other_social_media' => $request->input('other_social_media') ?? $user->other_social_media,
              'year_join' => $request->input('year_join') ?? $user->year_join,
              'angkatan_kuliah' => $request->input('angkatan_kuliah') ?? $user->angkatan_kuliah
            ]);

            //return successful response
            return response()->json(['user' => $user, 'message' => 'Profile Edited Succesfully'], 200);
        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => 'Edit Profile Failed!'], 409);
        }
    }

    public function editPhoto(Request $request)
    {
        //validate incoming request
        $this->validate($request, [
            //
        ]);

        try {
            $iam = Auth::user();

            ($request->input('status')) ? $status = $request->input('status') : $status = null;

            $user = User::where('id', $iam->id)->first();

            ($request->file('photo') != null) ? $namaPhoto = url('/photo-profile').'/'.Str::random(32).'.'.$request->file('photo')->getClientOriginalExtension() : $namaPhoto = null;

            if (isset($user->photo)) {
                unlink(base_path().'/public/photo-profile/'.$user->photo);
            }

            $user->update([
              'photo' => $namaPhoto ?? $user->photo,
            ]);

            ($request->file('photo') != null) ? $request->file('photo')->move(base_path().('/public/photo-profile'), $namaPhoto) : null;

            //return successful response
            return response()->json(['user' => $user, 'message' => 'Photo Edited Succesfully'], 200);
        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => 'Edit Photo Failed!'], 409);
        }
    }

    public function editPassword(Request $request)
    {
        $this->validate($request, [
            'old_password'     => 'required',
            'new_password'     => 'required|min:6',
            'confirm_password' => 'required|same:new_password',
        ]);

        $data = $request->all();

        if(app('hash')->check($data['old_password'], Auth::user()->password)){
            try {
                $iam = Auth::user();

                $iam->password = app('hash')->make($data['new_password']);
                $iam->save();

                //return successful response
                return response()->json(['message' => 'Password Edited Succesfully'], 200);
            } catch (\Exception $e) {
                //return error message
                return response()->json(['message' => 'Edit Password Failed!'], 409);
            }
        }else{
            //return error message
            return response()->json(['message' => 'You Have Entered Wrong Password!'], 409);
        }
    }

    public function storeGCMToken(Request $request)
    {
      //validate incoming request
      $this->validate($request, [
          'gcmtoken' => 'string'
      ]);

      try {
          $iam = Auth::user();

          $iam->update([
            'gcmtoken' => $request->input('gcmtoken')
          ]);

          //return successful response
          return response()->json(['GCM Token' => $request->input('gcmtoken'), 'message' => 'GCM Token Stored Succesfully'], 200);
      } catch (\Exception $e) {
          //return error message
          return response()->json(['message' => 'Store GCM Token Failed!'], 409);
      }
    }
}
