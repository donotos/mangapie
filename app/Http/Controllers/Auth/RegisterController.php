<?php

namespace App\Http\Controllers\Auth;

use App\Library;
use App\LibraryPrivilege;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
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
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        // return an invalid object if registration is disabled; this will basically result in a back()
        if (! \Cache::get('app.registration.enabled', false))
            return null;

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => \Hash::make($data['password']),
        ]);

        // assign library permissions
        $defaultLibraries = \Cache::get('app.registration.libraries', []);
        if (! empty($defaultLibraries)) {
            foreach ($defaultLibraries as $libraryId) {
                $library = Library::findOrFail($libraryId);

                LibraryPrivilege::create([
                   'user_id' => $user->id,
                   'library_id' => $library->id
                ]);
            }
        }

        return $user;
    }
}
