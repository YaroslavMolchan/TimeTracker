<?php

namespace App\Http\Controllers\Auth;

use App\Contracts\UserRepository;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    /**
     * @var UserRepository
     */
    private $users;

    /**
     * LoginController constructor.
     * @param UserRepository $users
     */
    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    /**
     * Redirect the user to the Google authentication page.
     */
    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     */
    public function handleProviderCallback()
    {
        $socialite_user = Socialite::driver('google')->user();

        $google_user_id = $socialite_user->id;
        $user = $this->users->findByField('google_user_id', $google_user_id)->first();

        if (is_null($user)) {
            $user = $this->users->create([
                'google_user_id' => $google_user_id,
                'email' => $socialite_user->email,
                'name' => $socialite_user->name,
                'avatar' => $socialite_user->avatar
            ]);
        }

        Auth::loginUsingId($user->id);

        return redirect('/');
    }
}
