<?php

namespace App\Http\Controllers;

use App\Models\ActiveCode;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile.index');
    }

    public function managetwofactor()
    {
        return view('profile.two-factor-auth');
    }

    public function Postmanagetwofactor(Request $request)
    {
        $data = $request->validate([
            'type' => 'required|in:sms,off',
            'phone' => 'required_unless:type,off'
        ]);
        if ($data['type'] === 'sms') {
            if ($request->user()->phone_number !== $data['phone']) {

                $code = ActiveCode::GenerateCode(auth()->user());
                $request->session()->flash('phone', $data['phone']);

                return redirect(route('profile.TwoFactorPhone'));
            } else {
                $request->user()->update([
                    'two_factor_type' => 'sms'
                ]);
            }
        }
        if ($data['type'] === 'off') {
            $request->user()->update([
                'two_factor_type' => 'off'
            ]);
        }


        return back();

    }

    public function getphoneVerify(Request $request)
    {
        if (!$request->session()->has('phone')) {
            return redirect(route('profile.twofactor'));
        }

        $request->session()->reflash();



        return view('profile.phone_verify');
    }

    public function postphoneVerify(Request $request)
    {

        $request->validate([
            'token' => 'required'
        ]);

        if (!$request->session()->has('phone')) {
            return redirect(route('profile.twofactor'));
        }
        $status = ActiveCode::verifyCode($request->token, $request->user());

        if ($status) {
            $request->user()->activeCode()->delete();
            $request->user()->update([
                'phone_number' => $request->session()->get('phone'),
                'two_factor_type' => 'sms'
            ]);


            alert()->success('شماره تلفن و احرازهویت دو مرحلهای شما تایید شد.', 'عملیات موفقیت آمیز بود');

        } else {
            alert()->error('شماره تلفن و احرازهویت دو مرحلهای شما تایید نشد.', 'عملیات ناموفق بود');
        }

        return redirect(route('profile.twofactor'));


    }
}
