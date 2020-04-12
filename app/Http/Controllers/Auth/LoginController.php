<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
//    use FormRequest;

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::ADMIN;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:admin')->except(['logout']);
    }



    public function showLoginForm()
    {
        return view('admin.layout.login');
    }

    /**
     * @param Request $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        // 验证用户名登录方式
        $usernameLogin = $this->guard()->attempt(
            ['username' => $username, 'password' => $password, 'status' => 1], $request->has('remember')
        );

        if ($usernameLogin) {
            return true;
        }

        // 验证邮箱登录方式
        $emailLogin = $this->guard()->attempt(
            ['email' => $username, 'password' => $password], $request->has('remember')
        );
        if ($emailLogin) {
            return true;
        }
        return false;
    }

    /**
     * Validate the user login request.
     *
     * @param Request $request
     *
     */

    protected function validateLogin(Request $request)
    {
        $validate = [
            $this->username() => 'required|string',
            'password' => 'required|string',
        ];
        if(config('captcha.enable'))
            $validate['verify'] = 'required|captcha';

        $rule = [
            'require'   =>  ':attribute不能为空',
            'string'    =>  ':attribute需为字符串',
            'captcha'   =>  ':attribute校验错误'
        ];

        $field = [
            $this->username()   =>  '用户名',
            'password'          =>  '密码',
            'verify'            =>  '验证码'
        ];


        $validator = Validator::make($request->all(),$validate,$rule,$field);

        if($validator->fails())
        {
            throw new HttpResponseException(response()->json(['status'=>-1,'msg'=>$validator->errors()->first()],
                200));
        }
    }

    /**
     * Log the user out of the application.
     *
     * @param Request $request
     * @return RedirectResponse|Redirector
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return redirect(route('admin.login'));
    }

    public function guard()
    {
        return Auth::guard('admin');
    }

    public function username()
    {
        return "username";
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param Request $request
     * @return JsonResponse
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        return $this->authenticated($request, $this->guard()->user())
            ?: response()->json(['status'=>1,'msg'=>'登录成功','url'=>$this->redirectPath()]);
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        return response()->json(['status'=>-1,'msg'=>'用户名或密码错误']);
//        throw ValidationException::withMessages([
//            $this->username() => [trans('auth.failed')],
//        ]);
    }

}
