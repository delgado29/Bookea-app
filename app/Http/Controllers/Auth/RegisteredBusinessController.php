<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Models\Business;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use App\Providers\RouteServiceProvider;

class RegisteredBusinessController extends Controller
{
    // Show the form
    public function create()
    {
        return view('auth.register-business');
    }

    // Handle the form POST
    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|string|email|max:255|unique:users',
            'password'   => ['required', 'confirmed', Rules\Password::defaults()],
            'business_name' => 'required|string|max:255',
            // Add more fields for business if you like
            // e.g. 'phone' => 'required|string',
        ]);

        // 1) Create the user with business_admin role
        $adminRole = Role::where('name', 'business_admin')->first();
        
        $user = User::create([
            'role_id'   => $adminRole->id,
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            // if you want address, phone, etc., include them here
        ]);

        // 2) Create the business
        $business = Business::create([
            'owner_id' => $user->id, 
            'name'     => $request->business_name,
            // 'phone' => $request->phone,
            // 'address' => $request->address,
            // etc.
        ]);
        $user->businesses()->attach($business->id);

        // 3) Auto-login the new admin (optional)
        auth()->login($user);

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