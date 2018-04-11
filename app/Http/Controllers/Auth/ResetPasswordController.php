<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller {

    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/';

    private $token = null;
    private $email = null;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest');
    }

    /**
     * Get the password reset validation rules.
     *
     * @return array
     */
    protected function rules() {
        return [
            'token'    => 'required',
            'email'    => 'required|email',
            'password' => 'required|min:6'
        ];
    }

    /**
     * Get the password reset credentials from the request.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return array
     */
    protected function credentials(Request $request) {
        $passwordResetData = $request->only(
            'email', 'password', 'token'
        );
        $passwordResetData['password_confirmation'] = $passwordResetData['password'];

        return $passwordResetData;
    }

    /**
     * Display the password reset view for the given token.
     *
     * If no token is present, display the link request form.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  string|null              $token
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showResetForm(Request $request, $token = null) {
        $this->token = $token;
        DB::table(config('auth.passwords.users.table'))->orderBy('created_at')->chunk(100, function ($resets) {

            foreach ($resets as $reset) {

                if (Hash::check($this->token, $reset->token)) {
                    $this->email = $reset->email;
                    break;
                }
            }
        });

        return view('auth.passwords.reset')->with(
            ['token' => $token, 'email' => $this->email]
        );
    }
}
