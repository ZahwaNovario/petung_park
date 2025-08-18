<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Gallery;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;

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

    protected $redirectTo = '/beranda';

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'date_of_birth' => $data['dob'],
            'position' => 'user',
            'gender' => $data['gender'],
            'phone_number' => $data['phone'],
            'status' => 1,
            'gallery_id' => 19,
        ]);
    }

    public function register_process(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'dob' => ['required', 'date'],
            'gender' => ['required', 'string'],
            'phone' => ['required', 'string', 'max:15'],
        ], [
            'email.unique' => 'Email sudah terdaftar.',
            'email.required' => 'Email harus diisi.',
            'password.required' => 'Kata sandi harus diisi.',
            'password.min' => 'Kata sandi harus terdiri dari minimal 8 karakter.',
            'password.confirmed' => 'Kata sandi tidak sama dengan konfirmasi kata sandi.',
            'name.required' => 'Nama harus diisi.',
            'dob.required' => 'Tanggal lahir harus diisi.',
            'gender.required' => 'Jenis kelamin harus diisi.',
            'phone.required' => 'Nomor telepon harus diisi.',
        ]);

        // Check if email is a Gmail address
        if (!filter_var($request->email, FILTER_VALIDATE_EMAIL) || !str_ends_with($request->email, '@gmail.com')) {
            return back()->withErrors(['email' => 'Email harus berupa alamat Gmail yang valid.']);
        }

        if (User::where('email', $request->email)->exists()) {
            return back()->withErrors(['email' => 'Email sudah digunakan.']);
        }

        $user = $this->create($request->all());        

        // Send the verification email
        event(new Registered($user));  // This triggers the sending of the verification email

        // Log the user in
        Auth::login($user);

        return redirect(RouteServiceProvider::HOME)->with('success', 'Selamat datang, registrasi berhasil! Silakan verifikasi email Anda.');
    }

    public function register()
    {
        $galleries = Gallery::all();
        return view('auth.register', compact('galleries'));
    }
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('register')->with('success', 'You have successfully logged out.');
    }
}
