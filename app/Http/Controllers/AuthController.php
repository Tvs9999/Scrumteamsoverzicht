<?php

namespace App\Http\Controllers;

use App\Mail\Activation;
use App\Models\User;
use App\Models\Classes;
use App\Models\Scrumteam;
use App\Models\ScrumteamUser;
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
            'password' => 'required|string|min:8|max:255|regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*[\W_]).+$/', // Example validation rule for password (minimum 8 characters)
            // Add any other validation rules for your fields here
        ], [
            '*.max' => 'Maximaal 255 karakters',
            'email.required' => 'Het e-mailveld is verplicht',
            'email.email' => 'Vul een geldig e-mailadres in',
            'password.required' => 'Het wachtwoordveld is verplicht',
            'password.regex' => 'Het wachtwoord moet ten minste 8 tekens bevatten, waaronder minimaal 1 kleine letter, 1 hoofdletter, 1 cijfer en 1 speciaal teken',
            'password.min' => 'Het wachtwoord moet ten minste 8 tekens bevatten, waaronder minimaal 1 kleine letter, 1 hoofdletter, 1 cijfer en 1 speciaal teken',
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
        $classNumbers = Classes::all(); // Assuming 'number' is the column name

        return view('register', compact('classNumbers'));
    }

    public function registerPost(Request $request)
    {
        $guid = bin2hex(openssl_random_pseudo_bytes(16));


        $validatedData = $request->validate([
            'email' => 'required|email|unique:users', // Example validation rules for email
            'rol' => 'required',
        ], [
            'email.unique' => 'Er is al een account met dit e-mailadres',
            'email.email' => 'Vul een geldig e-mailadres in',
            'email.required' => 'Het e-mailadres is verplicht',
            'rol.required' => 'De rol moet geselecteerd worden',
            '*' => 'Deze velden moeten ingevuld worden',
        ]);

        $user = new User([
            'email' => $validatedData['email'],
        ]);

        if ($request->rol == 1){
            if (isset($request->klas) || isset($request->new_class_number)){
                return back()->withErrors(['error' => 'Vul alleen de benodigde gegevens in voor een docent']);
            }
        } elseif ($request->rol == 0) {
            if (isset($request->new_class_number)){
                $classNumber = $request->new_class_number;
        
                $class = Classes::firstOrNew(['name' => $classNumber]);
                if (!$class->exists) {
                    $class->name = $request->new_class_number;
                    // The class doesn't exist, so save it
                    $class->save();
                } else {
                    return back()->withErrors(['error' => 'Deze klas bestaat al']);
                }
                $user->class_id = $class->id;
            } else{
                $class = Classes::where('id', $request->klas)->first();

                if ($class) {
                    $user->class_id = $class->id;
                } else {
                    return back()->withErrors(['error' => 'Deze klas bestaat niet']);
                }
            }

            


        } else{
            return back()->withErrors(['error' => 'Gebruiker niet aan kunnen maken']);
        }
        

        $user->email = $request->email;
        $user->role = $request->rol;
        $user->present = 0;
        $user->activation_key = $guid;

        if ($user->save()) {
            if ($user->role == 0) {
                $rol = "student";
            } else {
                $rol = "docent";
            }

            try {
                $this->Sendmail($user->email, $user->activation_key, $rol);
                Log::info('Email sent successfully to ' . $user->email);

                return back()->with('success', 'Er is een account gemaakt, en er is geprobeerd een mail te versturen naar ' . $user->email);
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
            'first_name' => 'required|string|min:2|max:255',
            'last_name' => 'required|string|min:2|max:255',
            'password' => 'required|string|min:8|regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*[\W_]).+$/', // Example validation rule for password (minimum 8 characters)
            // Add any other validation rules for your fields here
        ], [
            'password' => 'Het wachtwoord moet ten minste 8 tekens bevatten, waaronder minimaal 1 kleine letter, 1 hoofdletter, 1 cijfer en 1 speciaal teken',
            'first_name.min' => 'Minimaal 2 karakters',
            'last_name.min' => 'Minimaal 2 karakters',
            '*.required' => 'Dit veld is verplicht',
        ]);
        // Get the activation code from the query parameters
        $activationCode = $request->query('code');

        // Check if the code exists in the database
        $user = User::where('activation_key', $activationCode)->first();

        if ($user->update([
            'firstname' => $request->input('first_name'),
            'lastname' => $request->input('last_name'),
            'password' => Hash::make($request->input('password')), // Hash the new password
        ])){
            auth()->login($user);

            return redirect('dashboard'); // terugsturen naar login pagina
        }
        
        return back()->withErrors('Account bevestigen mislukt');

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
        $member = User::find($memberId);

        if ($member && $member->id != Auth::user()->id){
            // dd($member);

            $loggedInUserId = Auth::id(); // Assuming you are using Laravel's authentication
            $memberInScrumteam = ScrumteamUser::where('user_id', $member->id)
                ->whereHas('scrumteam', function ($query) use ($loggedInUserId) {
                    // Apply conditions to the 'scrumteam' relationship
                    $query->where('status', 0)
                        ->whereHas('users', function ($subquery) use ($loggedInUserId) {
                            // Check if the logged-in user is also a member of the same Scrum team
                            $subquery->where('user_id', $loggedInUserId);
                        });
                })
                ->exists();

            if(!$memberInScrumteam){
                return back()->with('error', 'Gebruiker zit niet in jou team');
            }
        }

        if($member && ($status == 0 || $status == 1)){
            // Update the status in the database
            $member->present = $status;

            if($member->save()){
                // Redirect back to the previous page or any other appropriate action
                return back()->with('success', 'Presentie succesvol aangepast');       
            } else {
                return back()->with('error', 'Presentie aangeven is mislukt');
            } 
        } else {
            return back()->with('error', 'Presentie aangeven is mislukt');
        }
    }
}
