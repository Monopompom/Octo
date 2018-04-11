<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
        /** @var User $currentUser */
        $currentUser = Auth::user();
        $userName = '';

        if ($currentUser instanceof User) {
            $userName = $currentUser->getNiceName();
        }

        if ($currentUser && !$currentUser->organization_id) {
            return view('app/organizations/new', [
                'user_name' => $userName
            ]);
        }

        $currentOrganization = Organization::find($currentUser->organization_id);

        return redirect($currentOrganization->name . '/dashboard');
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function create(Request $request) {
        $this->validateCreate($request->only(['name']));

        $currentUser = Auth::user();

        $organization = Organization::create([
            'name'       => mb_strtolower($request->get('name'), "utf-8"),
            'route_name' => mb_strtolower($request->get('name'), "utf-8"),
            'leader_id'  => $currentUser->id
        ]);

        $currentUser->organization_id = $organization->id;

        $currentUser->save();

        return redirect($organization->name . '/dashboard');
    }

    private function validateCreate($data) {
        return Validator::make(
            $data,
            [
                'name' => 'required|string|alpha_dash|min:1|max:150|unique:tbl_octo_organizations'
            ]
        )->validate();
    }
}
