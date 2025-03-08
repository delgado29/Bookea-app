<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Providers\RouteServiceProvider;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|confirmed|min:8',
    ]);

    // Get the "customer" role
    $customerRole = Role::where('name', 'customer')->first();

    $user = User::create([
        'role_id' => $customerRole->id,
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    Auth::login($user);

    $roleName = auth()->user()->role->name; // e.g. "customer", "business_admin", "employee", "developer"

    switch ($roleName) {
        case 'business_admin':
            return redirect()->route('business.dashboard');
        case 'employee':
            return redirect()->route('employee.dashboard');
        case 'developer':
            return redirect()->route('developer.dashboard');
        default:
            // default is "customer"
            return redirect()->route('customer.dashboard');
    }
    }
}