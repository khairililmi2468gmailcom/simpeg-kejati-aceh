<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UbahPasswordController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('admin.ubahpassword.index', compact('user'));
    }

    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'password' => 'required|string|min:8|confirmed',

        ]);

        if (!preg_match('/^(?=.*[A-Z])(?=.*\d).{8,}$/', $request->password)) {
            return back()->withErrors(['password' => 'Password harus mengandung huruf besar dan angka.']);
        }
        if ($validator->fails()) {
            return redirect()->route('admin.ubahpassword.index')
                ->withErrors($validator)
                ->withInput();
        }

        $user = Auth::user();
        $user->password = bcrypt($request->password);
        $user->save();

        return redirect()->route('admin.ubahpassword.index')->with('success', 'Profil berhasil diperbarui!');
    }
}
