<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ReCaptchaTrait;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller {

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

    use AuthenticatesUsers, ReCaptchaTrait;

    /**
     * Auth guard
     *
     * @var
     */
    protected $auth;

    protected $maxAttempts = 5;
    protected $decayMinutes = 5;

    /**
     * Create a new controller instance.
     *
     * @param Guard $auth
     */
    public function __construct(Guard $auth) {
        $this->middleware('guest')->except('logout');

        $this->auth = $auth;
    }

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request) {
        $email = $request->get('email');
        $password = $request->get('password');
        $remember = $request->get('remember');

        $user = $this->checkUserExistence($email);

        $this->validateLogin($request, $user);

        $is_attempt_successful = $this->auth->attempt(
            [
                'email'    => $email,
                'password' => $password
            ]
            , $remember == "on" ? true : false
        );

        if ($user && $is_attempt_successful) {
            $request->session()->regenerate();

            $this->clearLoginAttempts($request);

            $user->login_attempts = 0;

            $user->save();

            return $this->sendLoginResponse($request);
        }

        if ($user) {
            $user->login_attempts++;

            $user->save();
        } else {
            $this->incrementLoginAttempts($request);
        }

        if ($this->hasTooManyLoginAttempts($request) || $this->userHasTooManyLoginAttempts($user)) {
            return $this->showCaptcha();
        }

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @param   User                    $user
     *
     * @return void
     */
    protected function validateLogin(Request $request, $user) {
        $messages = [];
        $required = [
            $this->username() => 'required',
            'password'        => 'required'
        ];

        if ($this->hasTooManyLoginAttempts($request) || $this->userHasTooManyLoginAttempts($user)) {
            $required['g-recaptcha-response'] = 'required';
            $required['captcha-verified'] = 'required|min:1';

            $messages['g-recaptcha-response.required'] = 'Please confirm that you are not a robot';
            $messages['captcha-verified.min'] = 'Captcha verification failed';

            $request->offsetSet('captcha-verified', $this->verifyCaptcha($request->get('g-recaptcha-response')));
        }

        $this->validate($request, $required, $messages);
    }

    private function checkUserExistence($email) {
        return User::where('email', $email)->first();
    }

    private function userHasTooManyLoginAttempts($user) {
        return ($user) ? $user->login_attempts >= $this->maxAttempts : false;
    }

    private function showCaptcha() {
        throw ValidationException::withMessages(
            [
                $this->username()      => trans('auth.failed'),
                'g-recaptcha-response' => 'Too many login attempts. Please, enter captcha'
            ]
        );
    }
}
