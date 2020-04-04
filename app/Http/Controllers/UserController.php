<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\Group;
use App\User;
use App\Doctor;

class UserController extends Controller
{
    private function validation($type, $request, $id = null) {
        $this->validate($request, [
            'groups.*' => 'required|exists:groups,id',
            'name' => 'required',
            'phone_number' => 'required|numeric',
            'address' => 'required',
            'email' => 'required|unique:users,email,'.$id.''
        ]);
    }

    public function index()
    {
        return view('admin.user.index');
    }

    public function form($type, $id = null)
    {
        if ($type == 'create') {
            $data = null;
            return view('admin.user.form', compact('type', 'data'));
        } elseif ($type == 'edit') {
            $data = User::where('id', $id)->first();
            // return response()->json($data);
            return view('admin.user.form', compact('type', 'data', 'id'));
        } else {
            abort(404);
        }
    }

    public function store(Request $request)
    {
        $this->validation('store', $request);
        DB::beginTransaction();
        try {
            $request->request->add(['password' => bcrypt('password')]);
            $user = User::create($request->except('groups', 'doctor_speciality_id'));
            if (in_array('4', $request->groups)) {
                Doctor::create([
                    'user_id' => $user->id,
                    'doctor_speciality_id' => $request->doctor_speciality_id
                ]);
            }
            $user->groups()->sync($request->groups);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message' => $th->getMessage()], $th->getCode() == 0? 500 : $th->getCode());
        }
    }

    public function update(Request $request, $id)
    {
        $this->validation('update', $request, $id);
        DB::beginTransaction();
        try {
            User::where('id', $id)->update($request->except('groups', 'doctor_speciality_id'));
            User::find($id)->groups()->sync($request->groups);
            if (in_array('4', $request->groups)) {
                $check = Doctor::where('user_id', $id)->first();
                if ($check) {
                    Doctor::where('user_id', $id)->update(['doctor_speciality_id' => $request->doctor_speciality_id]);
                } else {
                    Doctor::create([
                        'user_id' => $id,
                        'doctor_speciality_id' => $request->doctor_speciality_id
                    ]);
                }
            } else {
                Doctor::where('user_id', $id)->delete();
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message' => $th->getMessage()], $th->getCode() == 0? 500 : $th->getCode());
        }
    }

    public function status(Request $request, $id)
    {
        User::where('id', $id)->update(['status' => $request->status]);
    }

    public function delete($id)
    {
        User::where('id', $id)->delete();
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

    public function groupList(Request $request)
    {
        if ($request->q) {
            $group = Group::where('name', 'like', '%'.$request->q.'%')->get();
        } elseif ($request->id) {
            $group = Group::where('id', $request->id)->first();
        } else {
            $group = Group::get();
        }
        return response()->json(['data' => $group]);
    }
}
