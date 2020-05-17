<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Role;
use App\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user)
    {
        $allUsersEmailsArray = User::pluck('email')->toArray();

        // Figure out if user_name or user_email is set and act accordingly
        // Change the user_name
        if (isset($request['user_name'])) {
            $userName = $request['user_name'];
            $user->name = $userName;
            $user->save();
            return back()->with('success', 'Username changed');
        }

        // Change the user_email
        if (isset($request['user_email'])) {
            $userEmail = $request['user_email'];

            // If the user_email is already taken return with the user_id which is blocking
            if (in_array($userEmail, $allUsersEmailsArray)){
                $blockingUser = User::select('id')->where('email', $userEmail)->pluck('id');
                return back()->with('error', 'This email is already taken by user_id = '.$blockingUser[0]);
            }
            $user->email = $userEmail;
            $user->save();
            return back()->with('success', 'Email changed');
        }
        return back()->with('error', 'Something went wrong');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($userId){
        $loggedInUser = auth()->id();

        if ($userId == $loggedInUser) {
            return back()->with('error', 'You cannot delete the logged in user');
        }

        if ($userId !== $loggedInUser) {
            $user = User::find($userId);
            $user->delete();
            return back()->with('success', 'User deleted');
        } else {
            return back()->with('error', 'Cannot proceed with action');
        }
    }

    /**
     * Assign user_role to user.
     *
     * @param Request $request
     * @param null $userId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function assignRole(Request $request, $userId = null){
        $role = $request['role'];
        // fetch the id of the at the moment assigned role
        $role = Role::select('id')->where('name', $role)->first();

        if (auth()->user()->id == $userId){
            return back()
                ->with('error', 'You cannot change the role of the logged in user');
        }

        if ($userId AND $role){
            $user = User::find($userId);
            $user->role()->associate($role)->save();

            return back()
                ->with('success', 'Role changed');
        }
        return back()
            ->with('error', 'Role could not be changed');
    }

    /**
     * Assign accommodation to user.
     *
     * @param Request $request
     * @param User $user
     * @param null $userId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function assignAccommodation(Request $request, $userId){
        $user = User::find($userId);
        $user->accommodation_id = $request['accommodation_id'];
        $user->save();
        return back()
            ->with('success', 'Accommodation changed');
    }
}
