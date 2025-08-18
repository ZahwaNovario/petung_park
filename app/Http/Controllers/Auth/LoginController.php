<?php
namespace App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
    public function login_process(Request $request)
    {
        // Validate input
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ],
        [
            'email.unique' => 'Email sudah terdaftar.',
            'email.required' => 'Email harus diisi.',
            'password.required' => 'Kata sandi harus diisi.',
            'password.min' => 'Kata sandi harus terdiri dari minimal 8 karakter.',
            'password.confirmed' => 'Kata sandi tidak sama dengan konfirmasi kata sandi.',
        ]);

        // Check if the email exists in the database
        if (!User::where('email', $request->input('email'))->exists()) {
            return redirect()->back()->withErrors(['email' => 'Email tidak ditemukan.'])->withInput();
        }

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember'); // Check if "remember" is checked
        
        $user = User::where('email', $request->input('email'))->first();
        
        // Check if the user's account is disabled
        if ($user && $user->status == 0) {
            return redirect()->back()->withErrors(['email' => 'Akun Anda telah dinonaktifkan.'])->withInput();
        }
        
        // Attempt to authenticate the user
        if (Auth::attempt($credentials, $remember)) {
            // Handle "remember me" logic
            if ($remember) {
                $user = Auth::user();
                if (is_null($user->remember_token)) {
                    $user->remember_token = bin2hex(random_bytes(64)); // Generate a random token
                    $user->save();
                }
            }
            
            // Redirect based on user role
            if (Auth::user()->position === 'Admin' || Auth::user()->position === 'Staff') {
                return redirect()->route('admin.index');
            }

            return redirect()->intended('/beranda')->with('Berhasil', 'Login Sukses!');
        }

        // If login failed, return with errors
        return redirect()->back()->withErrors(['password' => 'Kata sandi salah.'])->withInput();
    }

    public function login()
    {
        return view('auth.login');
    }
    public function logout(Request $request)
    {
        // Logout the user
        $user = Auth::user();
        $user->remember_token = null;
        $user->save();

        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda berhasil keluar!');
    }
}
