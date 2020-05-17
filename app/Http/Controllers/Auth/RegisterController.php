<?php

namespace App\Http\Controllers\Auth;

use App\Mail\InviteCreated;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use App\Http\Controllers\Controller;
use App\User;
use App\Role;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use MagicLink\Actions\LoginAction;
use MagicLink\MagicLink;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/admin/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:manage-app');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {

        $roleId = Role::select('id')->where('name', 'Guest')->first()->id;

        // can only create guest users by default
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role_id' => $roleId,
        ]);
    }

    /**
     * Handle a registration request for the application and
     * overwrites core login after registration functionality.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        if ($request['invite']) {
            $this->invite($user);
            return $this->registered($request, $user)
                ?: redirect($this->redirectPath())
                    ->with('success', 'User registered and invite sent');
        }

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath())
                ->with('success', 'User registered');
    }

    /**
     * Sends magic login link to invited email address
     *
     * @param $user
     */
    public function invite($user)
    {

        // invite() called from Dashboard
        if (is_numeric($user)){
            $user = User::find($user);
        }

        $adminRole = Role::where('name', 'Admin')->pluck('id');
        $responsibleAdmin = User::where('role_id', $adminRole)->first();

        // Create MagicLink for login of guest users; valid for 14 days and 2 visits of the page
        $lifetime = 20160;
        $numMaxVisits = 2;

        // Make a dataArray to use the data for the Email template invite.blade.php
        $dataArray = [];
        $dataArray ['url'] = MagicLink::create(new LoginAction($user, redirect('/guests')), $lifetime, $numMaxVisits)->url;
        $dataArray ['toName'] = $user->name;
        $dataArray ['accommodation'] = $user->accommodation->name;
        $dataArray ['lifetime'] = $lifetime;
        $dataArray ['numMaxVisits'] = $numMaxVisits;
        $dataArray ['fromEmail'] = $responsibleAdmin->email;

        // Send an email to the invitee
        Mail::to($user->email)->send(new InviteCreated($dataArray));

        return back()
            ->with('success', 'Invite sent');
    }
}
