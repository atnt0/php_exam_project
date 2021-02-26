<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // определить блокировку пользователя на этапе логина не получается
//    // переопределил метод логина для проверки блокировки пользователя
//    public function login(Request $request)
//    {
//        //dd($request->all());
//
//        $result = Auth::attempt([
//            'email' => $request->email,
//            'password' => $request->password,
//            //'isActive' => '1'
//        ]);
//        dd($result);
//
//        if ( $result )
//        {
//            dd($user);
//
//            // Updated this line
//            return $this->sendLoginResponse($request);
//
//            // OR this one
//            // return $this->authenticated($request, auth()->user());
//        }
//        else
//        {
//            return $this->sendFailedLoginResponse($request, 'auth.failed_status');
//        }
//    }

//    /**
//     * Handle a login request to the application.
//     *
//     * @param  \Illuminate\Http\Request  $request
//     * @return \Illuminate\Http\Response
//     */
//    public function login(Request $request)
//    {
//        //dd($request);
//
//        $this->validateLogin($request);
//
//        $user = User::where('email', $request->email)->firstOrFail();
//
//        if ( $user && $user->blocked_at != null ) {
//            return $this->sendLockedAccountResponse($request);
//        }
//
//        if ($this->hasTooManyLoginAttempts($request)) {
//            $this->fireLockoutEvent($request);
//
//            return $this->sendLockoutResponse($request);
//        }
//
//        if ($this->attemptLogin($request)) {
//            return $this->sendLoginResponse($request);
//        }
//
//        $this->incrementLoginAttempts($request);
//
//        return $this->sendFailedLoginResponse($request);
//    }
//
//    /**
//     * Get the locked account response instance.
//     *
//     * @param \Illuminate\Http\Request  $request
//     * @return \Illuminate\Http\Response
//     */
//    protected function sendLockedAccountResponse(Request $request)
//    {
//        return redirect()->back()
//            ->withInput($request->only($this->loginUsername(), 'remember'))
//            ->withErrors([
//                $this->loginUsername() => $this->getLockedAccountMessage(),
//            ]);
//    }

    /**
     * Get the locked account message.
     *
     * @return string
     */
    protected function getLockedAccountMessage()
    {
        return Lang::has('auth.locked')
            ? Lang::get('auth.locked')
            : 'Your account is inactive. Please contact the Support Desk for help.';
    }

}
