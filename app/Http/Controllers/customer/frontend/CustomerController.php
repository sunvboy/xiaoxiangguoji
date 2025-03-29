<?php

namespace App\Http\Controllers\customer\frontend;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Page;
use App\Models\PasswordReset;
use App\Notifications\ResetPasswordFrontend;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Auth;
use Socialite;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Components\System;
use App\Models\CustomerCategory;
use App\Rules\PhoneNumber;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\Rule;
use Validator;

class CustomerController extends Controller
{
    protected $system;
    public function __construct()
    {
        $this->system = new System();
    }
    public function login()
    {
        $page = Cache::remember('pageLogin', 60, function () {
            return Page::where(['alanguage' => config('app.locale'), 'page' => 'login', 'publish' => 0])->select('meta_title', 'meta_description', 'image', 'title', 'description')->first();
        });
        $seo['canonical'] = url('/');
        $seo['meta_title'] = !empty($page['meta_title']) ? $page['meta_title'] : $page['title'];
        $seo['meta_description'] = !empty($page['meta_description']) ? $page['meta_description'] : '';
        $seo['meta_image'] = !empty($page['image']) ? url($page['image']) : '';
        $fcSystem = $this->system->fcSystem();
        return view('customer/frontend/auth/login', compact('fcSystem', 'seo', 'page'));
    }
    public function loginAjax(Request  $request)
    {
        $phone = $request->phone;
        $password = $request->password;
        if (is_numeric($phone)) {
            $validator = Validator::make($request->all(), [
                'phone' => ['required', new PhoneNumber],
                'password' => 'required',
            ], [
                'phone.required' => 'Số điện thoại hoặc email là trường bắt buộc.',
                'password.required' => 'Mật khẩu là trường bắt buộc.',
            ]);
            $array = [
                'phone' => $phone,
                'password' => $password,
                'active' => 1,
            ];
        } else {
            $validator = Validator::make($request->all(), [
                'phone' => 'required|email',
                'password' => 'required',
            ], [
                'phone.required' => 'Số điện thoại hoặc email là trường bắt buộc.',
                'phone.email' => 'Email không đúng định dạng.',
                'password.required' => 'Mật khẩu là trường bắt buộc.',
            ]);
            $array = [
                'email' => $phone,
                'password' => $password,
                'active' => 1,
            ];
        }
        $remember = !empty($request->remember) ? true : false;
        if (Auth::guard('customer')->attempt($array, $remember)) {
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['error' => 'Tài khoản hoặc mật khẩu không đúng']);
        }
        return response()->json(['error' => $validator->errors()->all()]);
    }
    public function store(Request  $request)
    {
        $phone = $request->phone;
        $password = $request->password;
        if (is_numeric($phone)) {
            if (config('app.locale') == 'vi') {
                $request->validate([
                    'phone' => ['required', 'numeric', 'regex:/^(03|02|05|07|08|09|01[2|6|8|9])+([0-9]{8})$/'],
                    'password' => 'required',
                ], [
                    'phone.required' => 'EMAIL HOẶC SĐT không được để trống.',
                    'phone.regex'        => 'Số điện thoại không hợp lệ.',
                    'phone.numeric' => 'Số điện thoại không đúng định dạng.',
                    'password.required' => 'Mật khẩu là trường bắt buộc.',
                ]);
            } else {
                $request->validate([
                    'phone' => ['required', 'numeric', 'regex:/^(03|02|05|07|08|09|01[2|6|8|9])+([0-9]{8})$/'],
                    'password' => 'required',
                ]);
            }
            $array = [
                'phone' => $phone,
                'password' => $password,
                'active' => 1,
            ];
        } else {
            if (config('app.locale') == 'vi') {
                $request->validate([
                    'phone' => 'required|email',
                    'password' => 'required',
                ], [
                    'phone.required' => 'Email là trường bắt buộc.',
                    'phone.email' => 'Email không đúng định dạng.',
                    'password.required' => 'Mật khẩu là trường bắt buộc.',
                ]);
            } else {
                $request->validate([
                    'phone' => 'required|email',
                    'password' => 'required',
                ]);
            }
            $array = [
                'email' => $phone,
                'password' => $password,
                'active' => 1,
            ];
        }
        $remember = !empty($request->remember) ? true : false;
        if (Auth::guard('customer')->attempt($array, $remember)) {
            return redirect()->route('customer.dashboard');
        } else {
            return redirect()->route('customer.login')->withInput()->withErrors('Email hoặc mật khẩu không đúng!');
        }
    }
    //đăng ký
    public function register()
    {
        $page = Page::where(['alanguage' => config('app.locale'), 'page' => 'register', 'publish' => 0])->select('meta_title', 'description', 'meta_description', 'image', 'title')->first();
        $seo['canonical'] = route('customer.register');
        $seo['meta_title'] = !empty($page['meta_title']) ? $page['meta_title'] : $page['title'];
        $seo['meta_description'] = !empty($page['meta_description']) ? $page['meta_description'] : '';
        $seo['meta_image'] = !empty($page['image']) ? url($page['image']) : '';
        $fcSystem = $this->system->fcSystem();
        return view('customer/frontend/auth/register', compact('fcSystem', 'seo', 'page'));
    }
    public function register_store(Request  $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:customers',
            'phone' => ['required', new PhoneNumber, Rule::unique('customers')],
            'password' => 'required|min:6',
            'confirm_password' => 'required|min:6|same:password',
        ], [
            'name.required' => 'Họ và tên là trường bắt buộc.',
            'email.required' => 'Email là trường bắt buộc.',
            'email.email' => 'Email không đúng định dạng.',
            'email.unique' => 'Email đã tồn tại.',
            'phone.required' => 'Số điện thoại là trường bắt buộc.',
            'password.required' => 'Mật khẩu là trường bắt buộc.',
            'password.min' => 'Mật khẩu tối thiểu là 6 kí tự.',
            'confirm_password.min' => 'Nhập lại mật khẩu tối thiểu là 6 kí tự.',
            'confirm_password.required' => 'Nhập lại mật khẩu là trường bắt buộc.',
            'confirm_password.same' => 'Nhập lại mật khẩu không khớp với mật khẩu.',
        ]);
        $customer = Customer::create([
            'active' => 1,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => bcrypt($request->password),
            'created_at' => Carbon::now(),
        ]);
        //luu avatar mac dinh
        if ($customer) {
            $ch = curl_init('https://ui-avatars.com/api/?name=' . $customer->name);
            $img_name = '/upload/customer/' . slug($customer->name) . '-' . $customer->id . '.png';
            $fp = fopen(base_path() . $img_name, 'wb');
            curl_setopt($ch, CURLOPT_FILE, $fp);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_exec($ch);
            curl_close($ch);
            fclose($fp);
            Customer::find($customer->id)->update(['image' => $img_name]);
        }
        return redirect()->route('customer.login')->with('success', 'Đăng ký thành viên thành công');
    }
    //quên mật khẩu
    public function reset_password()
    {
        $fcSystem = $this->system->fcSystem();

        return view('customer.frontend.auth.reset-password', compact('fcSystem'));
    }
    public function reset_password_store(Request $request)
    {
        if (config('app.locale') == 'vi') {
            $request->validate([
                'email' => 'required|email',
            ], [
                'email.required' => 'Email là trường bắt buộc.',
                'email.email' => 'Email không đúng định dạng.',
            ]);
        } else {
            $request->validate([
                'email' => 'required|email',
            ]);
        }
        $user = Customer::where('email', $request->email)->first();
        if ($user) {
            $passwordReset = PasswordReset::updateOrCreate([
                'email' => $user->email,
            ], [
                'token' => Str::random(60),
            ]);
            if ($passwordReset) {
                //cấu hình email ứng dụng
                configEmail();
                $user->notify(new ResetPasswordFrontend($passwordReset->token));
            }
            return redirect()->route('customer.reset-password')->with('success', 'We have e-mailed your password reset link!');
        } else {
            return redirect()->route('customer.reset-password')->with('error', 'Tài khoản không tồn tại!');
        }
    }
    public function reset_password_new(Request $request)
    {

        $passwordReset = PasswordReset::where('token', $request->token)->firstOrFail();
        if (Carbon::parse($passwordReset->updated_at)->addMinutes(720)->isPast()) {
            $passwordReset->delete();
            return redirect()->route('customer.reset-password')->with('error', 'This password reset token is invalid.');
        }
        $user = Customer::where('email', $passwordReset->email)->firstOrFail();
        $passwordnew = Str::random(8);
        Customer::find($user->id)->update([
            'password' => bcrypt($passwordnew),
        ]);
        $passwordReset->delete();
        return redirect()->route('customer.login')->with('success', 'Mật khẩu mới: ' . $passwordnew);
    }
    //đăng xuất
    public function logout()
    {
        Auth::guard('customer')->logout();
        return redirect()->route('customer.login');
    }
    //login social
    function base64url_encode($text)
    {
        $base64 = base64_encode($text);
        $base64 = trim($base64, "=");
        $base64url = strtr($base64, "+/", "-_");
        return $base64url;
    }
    function generate_state_param()
    {
        // a random 8 digit hex, for instance
        return bin2hex(openssl_random_pseudo_bytes(4));
    }
    function generate_pkce_codes()
    {
        $random = bin2hex(openssl_random_pseudo_bytes(32)); // a random 64-digit hex
        $code_verifier = $this->base64url_encode(pack('H*', $random));
        $code_challenge = $this->base64url_encode(pack('H*', hash('sha256', $code_verifier)));
        return array(
            "verifier" => $code_verifier,
            "challenge" => $code_challenge
        );
    }
    //end
    public function redirect($provider)
    {
        //gọi login
        //cấu hình login facebook,google
        $settingSocialLogin = \App\Models\CustomerSocial::select('config')->where('id', 1)->first();
        /*
        if ($settingSocialLogin) {
            $socialConfig = json_decode($settingSocialLogin->config, true);
            config([
                'services.facebook.client_id' => !empty($socialConfig['facebook']) ? (!empty($socialConfig['facebook']['client_id_facebook']) ? $socialConfig['facebook']['client_id_facebook'] : '') : '',
                'services.facebook.client_secret' => !empty($socialConfig['facebook']) ? (!empty($socialConfig['facebook']['client_secret_facebook']) ? $socialConfig['facebook']['client_secret_facebook'] : '') : '',
                'services.facebook.redirect' => !empty($socialConfig['facebook']) ? (!empty($socialConfig['facebook']['redirect_facebook']) ? url($socialConfig['facebook']['redirect_facebook']) : '') : '',
            ]);
            config([
                'services.google.client_id' => !empty($socialConfig['google']) ? (!empty($socialConfig['google']['client_id_google']) ? $socialConfig['google']['client_id_google'] : '') : '',
                'services.google.client_secret' => !empty($socialConfig['google']) ? (!empty($socialConfig['google']['client_secret_google']) ? $socialConfig['google']['client_secret_google'] : '') : '',
                'services.google.redirect' => !empty($socialConfig['google']) ? (!empty($socialConfig['google']['redirect_google']) ? url($socialConfig['google']['redirect_google']) : '') : '',
            ]);
        } */
        if ($settingSocialLogin) {
            $socialConfig = json_decode($settingSocialLogin->config, true);
        }
        if ($provider == 'zalo') {
            session_start();
            $state = $this->generate_state_param(); // for CSRF prevention
            $codes = $this->generate_pkce_codes();
            $_SESSION["zalo_auth_state"] = $state;
            $_SESSION["zalo_code_verifier"] = $codes["verifier"];
            $auth_uri = 'https://oauth.zaloapp.com/v4/permission' . "?" . http_build_query(array(
                "app_id" => !empty($socialConfig['zalo']) ? (!empty($socialConfig['zalo']['client_id_zalo']) ? $socialConfig['zalo']['client_id_zalo'] : '') : '',
                "redirect_uri" => !empty($socialConfig['zalo']) ? (!empty($socialConfig['zalo']['redirect_zalo']) ? $socialConfig['zalo']['redirect_zalo'] : '') : '',
                "code_challenge" => $codes["challenge"],
                "state" => $state, // <- prevent CSRF
            ));
            header("Location: {$auth_uri}");
        } else {
            return Socialite::driver($provider)->redirect();
        }
    }
    public function callback($provider)
    {
        $settingSocialLogin = \App\Models\CustomerSocial::select('config')->where('id', 1)->first();
        if ($settingSocialLogin) {
            $socialConfig = json_decode($settingSocialLogin->config, true);
        }
        if ($provider == 'zalo') {
            session_start();
            $data = http_build_query(array(
                "app_id" => !empty($socialConfig['zalo']) ? (!empty($socialConfig['zalo']['client_id_zalo']) ? $socialConfig['zalo']['client_id_zalo'] : '') : '',
                "code" => $_REQUEST["code"],
                "code_verifier" => $_SESSION["zalo_code_verifier"],
                "grant_type" => "authorization_code"
            ));
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://oauth.zaloapp.com/v4/access_token',
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_HTTPHEADER => array(
                    "Content-Type: application/x-www-form-urlencoded",
                    "secret_key: " . !empty($socialConfig['zalo']) ? (!empty($socialConfig['zalo']['client_secret_zalo']) ? $socialConfig['zalo']['client_secret_zalo'] : '') : ''
                ),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_POSTFIELDS => $data,
                CURLOPT_SSL_VERIFYPEER => true,
                CURLOPT_FAILONERROR => true,
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            $auth = json_decode($response, true);
            $getInfo = curl_api('https://graph.zalo.me/v2.0/me?access_token=' . $auth["access_token"] . '&fields=id,name,picture');
            $image  = $getInfo->picture->data->url;
            $email = slug($getInfo->name) . $getInfo->id . '@gmail.com';
            unset($_SESSION["zalo_auth_state"]);
            unset($_SESSION["zalo_code_verifier"]);
        } else {
            $getInfo = Socialite::driver($provider)->user();
            $image = $getInfo->avatar;
            $email = !empty($getInfo->email) ? $getInfo->email : slug($getInfo->name) . $getInfo->id . '@gmail.com';
        }
        $checkUser = Customer::where('provider', '!=', $provider)->where('email', $email)->first();
        if ($checkUser) {
            return redirect()->route('customer.login')->withInput()->withErrors('Email đã được sử dụng!');
        } else {
            $user = Customer::where('provider_id', $getInfo->id)->first();
            if (!$user) {
                $user = Customer::create([
                    'name'     => $getInfo->name,
                    'email'    => $email,
                    'provider' => $provider,
                    'provider_id' => $getInfo->id,
                    'image' => $image
                ]);
            }
            Auth::guard('customer')->login($user);
            return redirect()->route('customer.dashboard');
        }
    }
}
