<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;

class EntryController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard if logged in.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke() {
        return redirect('login');
    }
}
