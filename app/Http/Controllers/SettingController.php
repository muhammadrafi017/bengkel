<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

use App\Setting;

class SettingController extends Controller
{
    public function profile()
    {
        $setting_name = ['clinic_name','clinic_description','clinic_address','clinic_contact','clinic_icon'];
        $data = Setting::where(function($query) use ($setting_name) {
            for ($i=0; $i < count($setting_name); $i++) { 
                $query->orWhere('name', 'like', '%'.$setting_name[$i].'%');
            }
        })->get();
        return view('setting.profile', compact('data'));
    }

    public function profileUpdate(Request $request)
    {
        DB::beginTransaction();
        try {
            $setting_name = ['clinic_name','clinic_description','clinic_address','clinic_contact','clinic_icon'];
            for ($i=0; $i < count($setting_name); $i++) { 
                if ($request->{$setting_name[$i]}) {
                    if ($request->file($setting_name[$i])) {
                        $existing = Setting::where('name', $setting_name[$i])->first();
                        if ($existing) {
                            Storage::delete($existing->value);
                        }
                        $filename = 'logo_'.strtotime(date('Y-m-d H:i:s')).'.'.$request->file($setting_name[$i])->getClientOriginalExtension();
                        Storage::putFileAs('public/img/setting', $request->file($setting_name[$i]), $filename);
                        $filename = 'storage/img/setting/'.$filename;
                        $request->{$setting_name[$i]} = $filename;
                    }
                    Setting::where('name', $setting_name[$i])->update(['value' => $request->{$setting_name[$i]}]);
                }
            }
            DB::commit();
        } catch (\Throwable $th) {
            $errors = null;
            if (method_exists($th, 'getMessage')) {
                $errors = ['message' => $th->getMessage()];
            } else {
                $errors = ['errors' => $th->errors];
            }
            DB::rollBack();
            return response()->json($errors, $th->getCode() == 0? 500 : $th->getCode());
        }
    }
}
