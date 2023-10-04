<?php

namespace App\Http\Controllers;

use App\Mail\Activation;
use App\Models\User;
use App\Models\Classes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use SebastianBergmann\Type\NullType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;

use function Laravel\Prompts\error;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:8|regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*[\W_]).+$/', // Example validation rule for password (minimum 8 characters)
            // Add any other validation rules for your fields here
        ], [
            'email.required' => 'Het e-mailveld is verplicht',
            'password.required' => 'Het wachtwoordveld is verplicht',
            'password.regex' => 'Het wachtwoord moet ten minste 8 tekens bevatten, waaronder minimaal 1 kleine letter, 1 hoofdletter, 1 cijfer en 1 speciaal teken',
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            // Login succes...
            $user = Auth::user();

            Session::put('user_role', Auth::user()->role);
            Session::put('userid', Auth::user()->id);
            Session::put('studentclassid', Auth::user()->class_id);
            //userrole/userid/classid wordt in de session toegevoegd
            return redirect()->intended(route('Dashboard'));
        }
        #error als de combinatie niet klopt
        return back()->withErrors(['error' => 'Gegevens zijn onjuist']);
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
            'rol' => 'required',
            'klas' => 'required',
        ], [
            'email.required' => 'Het e-mailadres is verplicht',
            'rol.required' => 'De rol moet geselecteerd worden',
            'klas.required' => 'De klas moeten nog geselecteerd worden',
            'new_class_number.required' => 'Nieuwe klasnummer moet nog toegevoegd worden',
            '*' => 'Deze velden moeten ingevuld worden',
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

        if ($user->save()) {
            if ($user->rol === 0) {
                $rol = "student";
            } else {
                $rol = "docent";
            }

            try {
                $this->Sendmail($user->email, $user->activation_key, $rol);
                Log::info('Email sent successfully to ' . $user->email);

                return back()->with('success', 'Er is een account gemaakt, degene krijgt een mail waar hij zijn account kan activeren!');
            } catch (\Exception $e) {
                Log::error('Email sending failed: ' . $e->getMessage());

                return back()->with('error', 'Er is een account gemaakt, maar er is een fout opgetreden bij het versturen van de activatiemail.');
            }
        } else {
            dd($user->errors());
        }
    }
    public function display_activationform(Request $request)
    {
        // Get the activation code from the query parameters
        $activationCode = $request->query('code');

        // Check if the code exists in the database
        $user = User::where('activation_key', $activationCode)->first();

        if (!$user || !empty($user->password)) {
            // Code not found, handle error (e.g., show an error message)

            return error("GEBRUIKER AL GEACTIVEERD");
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

        return redirect('dashboard'); // terugsturen naar login pagina

    }

    public function logout()
    {
        Auth::logout();
        Session::flush();

        return redirect('login'); // terugsturen naar login pagina
    }

    public function users()
    {
        // Retrieve users with role 0 and order them by role
        $role0Users = User::with('class')
            ->where('role', 0)
            ->whereNotNull('password')
            ->orderBy('role')
            ->get();

        // Retrieve users with role 1 and order them by role
        $role1Users = User::with('class')
            ->where('role', 1)
            ->whereNotNull('password')
            ->orderBy('role')
            ->get();

        // Retrieve users with empty passwords and order them by role
        $emptyPasswordUsers = User::with('class')
            ->whereNull('password')
            ->orderBy('role')
            ->get();

        // Concatenate the results in the desired order
        $users = $role0Users->concat($role1Users)->concat($emptyPasswordUsers);
        return view('users', compact('users'));
    }

    public function sendMail($email, $code, $rol)
    {

        Mail::to($email)->send(new Activation($code, $rol));
    }

    public function updateStatus($memberId, $status)
    {
        // Find the member by ID
        $member = User::findOrFail($memberId);

        // Update the status in the database
        $member->present = $status;

        $member->save();



        // Redirect back to the previous page or any other appropriate action
        return redirect()->back()->with('status?', 'Status updated successfully');
    }
}
