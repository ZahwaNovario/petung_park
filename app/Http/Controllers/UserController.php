<?php

namespace App\Http\Controllers;

use App\Models\Generic;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Gallery;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $staffs = User::all();
        return view('staf.index', compact('staffs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $galleries = Gallery::where('status', 1)
        ->where('name', 'like', 'Profile%')
        ->get();
        return view('staf.create', compact('galleries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'password' => 'required|string|confirmed',
                'date_of_birth' => 'required|date',
                'phone_number' => 'required|string|max:15',
                'position' => 'required|string',
                'gender' => 'required|string',
                'email' => 'required|email',
                'photo' => 'nullable|integer|exists:galleries,id',
            ],  [
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
            if (User::where('email', $request->input('email'))->exists()) {
                return redirect()->back()->withInput()->with('error', 'Email sudah digunakan.');
            }            
            $staff = [
                'name' => $request->input('name'),
                'status' => 1,
                'password' => bcrypt($request->input('password')),
                'date_of_birth' => $request->input('date_of_birth'),
                'phone_number' => $request->input('phone_number'),
                'position' => $request->input('position'),
                'gender' => $request->input('gender'),
                'email' => $request->input('email'),
            ];

            if ($request->has('photo')) {
                $staff['gallery_id'] = $request->input('photo');
            }
    
            $user = new User($staff);
            $user->save();

            return redirect()->route('staf.index')->with('success', 'Staf berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat input data: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function showAdminPage()
    {
        return view('admin.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $staff = User::where('id', $id)->first();
        if (!$staff) {
            return redirect()->route('staf.index')->with('error', 'Staff not found');
        }
        $galleries = Gallery::where('status', 1)
                            ->where('id', '!=', $staff->gallery_id)
                            ->where('name', 'like', 'Profile%')
                            ->get();
        return view('staf.edit', compact('staff', 'galleries'));
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $user)
    {
        try {
            $staff = User::findOrFail($user);
            $validated = $request->validate([
                'email' => 'required|email',
                'name' => 'required|string|max:255',
                'date_of_birth' => 'required|date',
                'phone_number' => 'required|string|max:15',
                'position' => 'required|string',
                'gender' => 'required|string',
                'status' => 'required|boolean',
                'old_photo' => 'nullable|integer|exists:galleries,id',
                'new_photo' => 'nullable|integer|exists:galleries,id',
                'oldPassword' => 'nullable|required_if:changePassword,on',
                'newPassword' => 'nullable|required_if:changePassword,on|confirmed',
            ],
            [
                'email.required' => 'Email harus diisi.',
                'name.required' => 'Nama harus diisi.',
                'date_of_birth.required' => 'Tanggal lahir harus diisi.',
                'phone_number.required' => 'Nomor telepon harus diisi.',
                'position.required' => 'Posisi harus diisi.',
                'gender.required' => 'Jenis kelamin harus diisi.',
                'status.required' => 'Status harus diisi.',
                'old_photo.exists' => 'Foto lama tidak ditemukan.',
                'new_photo.exists' => 'Foto baru tidak ditemukan.',
                'oldPassword.required_if' => 'Password lama harus diisi.',
                'newPassword.required_if' => 'Password baru harus diisi.',
                'newPassword.confirmed' => 'Password baru tidak sama dengan konfirmasi password.',
            ]);
            $staff->email = $validated['email'];
            $staff->name = $validated['name'];
            $staff->date_of_birth = $validated['date_of_birth'];
            $staff->phone_number = $validated['phone_number'];
            $staff->position = $validated['position'];
            $staff->gender = $validated['gender'];
            $staff->status = $validated['status'];

            if ($request->has('changePassword')) {
                if (Hash::check($validated['oldPassword'], $staff->password)) {
                    $staff->password = bcrypt($validated['newPassword']);
                } else {
                    return back()->withErrors(['oldPassword' => 'Password lama salah.']);
                }
            }
            if ($request->has('new_photo')) {
                if ($request->input('old_photo') != $request->input('new_photo')) {
                    $staff->gallery_id = $request->input('new_photo');
                }
            }
            $staff->updated_at = now();
            $staff->save();

            return redirect()->route('staf.index')->with('success', 'Data staff berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage());
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function unactivate(string $user)
    {
        try {
            DB::transaction(function () use ($user) {
                $staff = User::findOrFail($user);
                   $staff->status = 0;
                   $staff->updated_at = now();
                $staff->save();
            });
   
                return redirect()->route('staf.index')->with('success', 'Staf berhasil dinonaktifkan!');
            } catch (\Exception $e) {
                return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat menonaktifkan staf: ' . $e->getMessage());
            }
    }

}
