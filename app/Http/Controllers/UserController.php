<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\User;

class UserController extends Controller
{
    public function index()
    {
        return view('user.index');
    }


    public function changePassword(Request $request, $id)
    {
        $this->validate($request, [
            'old_password' => 'required|min:8',
            'new_password' => 'required|min:8|confirmed',
        ]);
        try {
            $user = User::where('id', $id)->first()->makeVisible(['password']);
            if (Hash::check($request->old_password, $user->password)) {
                $user->update(['password' => Hash::make($request->new_password)]);
            } else {
                throw new \Exception('Password lama salah', 422);
            }
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], $th->getCode() == 0? 500 : $th->getCode());
        }
    }

    public function findMember(Request $request)
    {
        $member = User::where('is_member', 1)->where('kode', $request->kode_member)->first();
        return response()->json(['data' => $member]);
    }
}
