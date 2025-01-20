<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    public function redirectToFacebook()
    {
        activity()
            ->causedBy(auth()->user()) // Logujemy aktualnie zalogowanego użytkownika
            ->withProperties(['action' => 'Redirecting to Facebook login'])
            ->log('User redirected to Facebook for authentication.');
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        try {
            $user = Socialite::driver('facebook')->user();
            $finduser = User::where('facebook_id', $user->id)->first();

            if ($finduser) {
                Auth::login($finduser);
                activity()
                    ->causedBy($finduser)
                    ->withProperties(['action' => 'Logged in via Facebook'])
                    ->log('User logged in using Facebook.');
                return redirect()->intended('dashboard');
            } else {
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'facebook_id'=> $user->id,
                    'password' => bcrypt(fake()->password(12)),
                ]);
                $newUser->email_verified_at=Carbon::now();
                $newUser->save();
                activity()
                    ->causedBy($newUser)
                    ->withProperties([
                        'action' => 'Created a new account via Facebook',
                        'email' => $user->email,
                    ])
                    ->log('New user account created via Facebook.');
                Auth::login($newUser);
                return redirect()->intended('dashboard');
            }
        } catch (\Exception $e) {
            activity()
                ->causedBy(auth()->user())
                ->withProperties(['action' => 'Facebook login failed', 'error_message' => $e->getMessage()])
                ->log('Facebook login attempt failed.');
            return redirect('/login')->withErrors(['error' => 'Logowanie przez Facebook nie powiodło się.']);
        }
    }

}
