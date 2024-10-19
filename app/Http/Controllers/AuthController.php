<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Staff;
use App\Models\Shift;
use App\Models\Salary;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'password' => ['required'],
        ]);
    
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            if (Auth::user()->name === 'admin') {
                return redirect('/home');
            } else {
                $staff = Staff::where('id', Auth::user()->staff_id)->first();
                return redirect()->route('crew.dashboard', ['name' => $staff->name]);
            }
        }
    
        return back()->withErrors([
            'name' => 'The provided credentials do not match our records.',
        ]);
    }

    public function showRegistrationForm()
    {
        $staffMembers = Staff::whereDoesntHave('user')->get();
        return view('register', compact('staffMembers'));
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'staff_id' => ['required', 'exists:staff,id'],
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => $validatedData['password'],
            'staff_id' => $validatedData['staff_id'],
        ]);

        Auth::login($user);

        return redirect('/');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function showAccountSettings()
    {
        $user = Auth::user();
        $name = $user->staff->name ?? $user->name;
        return view('account-settings', compact('user', 'name'));
    }

    public function updateAccountSettings(Request $request)
    {
        $user = Auth::user();
        
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $user->name = $validatedData['name'];
        $name = $user->staff->name ?? $user->name;
        
        if (!empty($validatedData['password'])) {
            $user->password = Hash::make($validatedData['password']);
        }

        $user->save();

        return redirect()->route('account.settings')->with('success', 'Account settings updated successfully.');
    }
}