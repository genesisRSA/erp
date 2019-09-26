<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use Illuminate\Http\Request;

class ICSLoginController extends Controller
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

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/ics/home';
    protected $redirectAfterLogout = '/ics';
    protected $username;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function credentials(Request $request)
    {
        $field = $this->field($request);

        return [
            $field => $request->get($this->username()),
            'password' => $request->get('password'),
        ];
    }

    /**
     * Determine if the request field is email or username.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    public function field(Request $request)
    {
        $email = $this->username();

        return filter_var($request->get($email), FILTER_VALIDATE_EMAIL) ? $email : 'username';
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $field = $this->field($request);

        $messages = ["{$this->username()}.exists" => 'The account you are trying to login is not registered or it has been disabled.'];

        $this->validate($request, [
            $this->username() => "required|exists:users,{$field}",
            'password' => 'required',
        ], $messages);
    }

    protected function authenticated(Request $request, $user){
        $user->api_token = Str::random(60);
        $user->save();
        if ($user->is_admin == 1) {
            return redirect('/ics/home');
        }else{
            Auth::logout();
            return redirect('/ics')->withErrors(["You dont have permission to access this site."]);
        }
    }

    public function logout(Request $request) {
        Auth::logout();
        return redirect('/ics');
    }
}
