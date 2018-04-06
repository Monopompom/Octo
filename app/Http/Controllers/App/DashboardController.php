<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller {

    public function index() {
        /** @var User $currentUser */
        $currentUser = Auth::user();
        $userName = '';

        if ($currentUser instanceof User) {
            $userName = $currentUser->getNiceName();
        }

        return view(
            'app/dashboard',
            [
                'user_name' => $userName
            ]
        );
    }
}
