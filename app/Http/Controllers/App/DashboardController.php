<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Models\User;
use App\Utils\StringFormatter;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    public function __invoke() {
        $userName = '';
        $organizationName = '';

        /** @var User $currentUser */
        $currentUser = Auth::user();

        if ($currentUser instanceof User) {
            $userName = $currentUser->getNiceName();
            $organizationName = Organization::find($currentUser->organization_id);
        }

        return view(
            'app/dashboard',
            [
                'user_name'         => $userName,
                'organization_name' => StringFormatter::mb_ucfirst($organizationName->name)
            ]
        );
    }
}