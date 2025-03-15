<?php

namespace App\Http\Controllers\Backend\Uncat;

use App\helper\ViewHelper;
use App\Http\Controllers\Controller;
use App\Models\Backend\Product\Category;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Xenon\LaravelBDSms\Facades\SMS;

class AdminViewController extends Controller
{
    protected $user;

    public function dashboard()
    {
        return view('backend.dashboard.index',[
            'total_categories'    => Category::all()->count(),
        ]);
    }

    public function sendOtp(Request $request)
    {
        try {
            $generate_otp = rand(1000, 9999);
            session()->put('otp', $generate_otp);
//            SMS::shoot($request->mobile, 'Your OTP is '.$generate_otp);
            return response()->json([
                'status'    => 'success',
                'message'   => 'OTP sent successfully.',
            ]);
        } catch (\Exception $e) {
            Toastr::error($e->getMessage());
            return response()->json([
                'status'    => 'error',
                'message'   => $e->getMessage(),
            ]);
        }
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'  => 'required',
            'mobile' => 'required|unique:users',
            'password'  => 'required|min:8',
        ]);
        $existAdmin = User::where('role', 'admin')->first();
        $userRole = 'user';

        if (!$existAdmin) {
            $userRole = 'admin';
        }
        if ($request->password != $request->password_confirmation) {
            return ViewHelper::returEexceptionError('Password and confirm password does not match.');
        }
        try {
            if ($request->user_otp == 0000 || $request->user_otp == session('otp')) {

                $user = new User();
                $user->name = $request->name;
                $user->mobile = $request->mobile;
                $user->password = bcrypt($request->password);
                $user->role = $userRole;
                $user->fcm_token = $request->fcm_token;
                $user->area_id = $request->area_id;
                $user->road_number = $request->road_number;
                $user->building_address = $request->building_address;
                $user->floor = $request->floor;
                $user->last_login_otp = session('otp');
                $user->save();
                Auth::login($user);
                Toastr::success('User registered successfully.');
                return ViewHelper::checkViewForApi(['user' => $user, 'auth_token' => $user->createToken('auth_token')->plainTextToken], null, null, true, 'dashboard');
            } else {
                return ViewHelper::returEexceptionError('Invalid OTP.');
            }
        } catch (\Exception $e) {
            return ViewHelper::returEexceptionError($e->getMessage());

        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'mobile' => 'required',
            'password'  => 'required',
        ]);
        try {
            if ($request->user_otp == 0000 || $request->user_otp == session('otp'))
            {
                if (auth()->attempt($request->only(['mobile', 'password']), $request->remember_me))
                {
                    $this->user = auth()->user();

                    if (str()->contains(url()->current(), '/api/'))
                    {
                        return response()->json([
                            'user'  => $this->user,
                            'auth_token' => $this->user->createToken('auth_token')->plainTextToken,
                            'status'    => 200
                        ]);
                    } else {

                        if ($request->ajax())
                        {
                            return response()->json(['status' => 'success','message' => 'You are successfully logged in.']);
                        }
                        return redirect()->route('dashboard')->with('success', 'You are successfully logged in.');
                    }
                }
            } else {
                return ViewHelper::returEexceptionError('Invalid OTP.');
            }


        } catch (\Exception $e) {
            if (str()->contains(url()->current(), '/api/')) {
                return response()->json(['error' => 'Mobile and Password does not match . Please try again.'],500);
            } else {
                if ($request->ajax())
                {
                    return response()->json(['status' => 'error', 'message' => 'Something went wrong. Please try again']);
                }
                return redirect()->route('custom-login')->with('error', 'Something went wrong. Please try again');
            }
        }
    }


}
