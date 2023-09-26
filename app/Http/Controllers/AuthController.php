<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Classes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use SebastianBergmann\Type\NullType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLoginForm()
    {   
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            // Login succes...
            $user = Auth::user();
            
            Session::put('user_role', Auth::user()->role);
            Session::put('userid', Auth::user()->id);
            Session::put('studentclassid', Auth::user()->class_id);

            return redirect()->intended(route('Dashboard'));
        }
        #error als de combinatie niet klopt
        return redirect()->route('login')->with('error', 'Log in is mislukt.');
    }

    public function register()
    {
        $classNumbers = Classes::pluck('name')->toArray(); // Assuming 'number' is the column name

        return view('register', compact('classNumbers'));
    }

    public function registerPost(Request $request)
    {
        $guid = bin2hex(openssl_random_pseudo_bytes(16));


        $validatedData = $request->validate([
            'email' => 'required|email|unique:users', // Example validation rules for email
            'klas' => 'required',
        ]);
        $classNumber = $validatedData['klas'];
        $class = Classes::firstOrNew(['name' => $classNumber]);
        if (!$class->exists) {
            $class->name = $request->new_class_number;
            // The class doesn't exist, so save it
            $class->save();
        }
        $user = new User([
            'email' => $validatedData['email'],
            'class_id' => $class->id,
        ]);

        $user->email = $request->email;
        $user->role = $request->rol;
        $user->present = 0;
        $user->class_id = $class->id;
        $user->activation_key = $guid;
        // $user->password = Hash::make($request->password);

        $user->save();

        return back()->with('succes', 'Register succesful');
    }
    public function display_activationform(Request $request)
    {
        // Get the activation code from the query parameters
        $activationCode = $request->query('code');

        // Check if the code exists in the database
        $user = User::where('activation_key', $activationCode)->first();

        if (!$user || !empty($user->password)) {
            // Code not found, handle error (e.g., show an error message)
            
            return;
        } else {
            return view('completeRegistration');
        }
    }
    public function activate_account(request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'password' => 'required|string|min:8|regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*[\W_]).+$/', // Example validation rule for password (minimum 8 characters)
            // Add any other validation rules for your fields here
        ], [
            'password' => 'Het wachtwoord moet ten minste 8 tekens bevatten, waaronder minimaal 1 kleine letter, 1 hoofdletter, 1 cijfer en 1 speciaal teken',
        ]);
        // Get the activation code from the query parameters
        $activationCode = $request->query('code');

        // Check if the code exists in the database
        $user = User::where('activation_key', $activationCode)->first();

        $user->update([
            'firstname' => $request->input('first_name'),
            'lastname' => $request->input('last_name'),
            'password' => Hash::make($request->input('password')), // Hash the new password
        ]);

        auth()->login($user);
    }

    public function logout()
    {
        Auth::logout();
        Session::flush();
        return redirect('login'); // Redirect to the desired URL after logout
    }
}
