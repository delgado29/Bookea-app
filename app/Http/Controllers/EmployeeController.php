<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Business;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function index(User $user)
    {
        // Verificar que el usuario es administrador del negocio
        $business = $user->ownedBusinesses()->first(); // Solo un negocio permitido
        if (!$business) {
            return back()->with('error', 'No business found.');
        }

        // Obtener empleados a través de la relación Many-to-Many, especificando el role_id
        $employees = $business->users()
            ->where('business_user.role_id', 3) // Solo empleados
            ->get();

        return view('employees.index', compact('employees', 'business'));
    }

    public function create($businessId)
    {
        $business = Business::findOrFail($businessId);
        return view('employees.create', compact('business'));
    }

    public function store(Request $request, $businessId)
    {
        // Validar que el email esté presente, sea un correo válido y que el usuario exista
        $request->validate([
            'email' => 'required|email|exists:users,email', // Validar que el usuario ya exista
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:12',
        ]);
    
        // Obtener el usuario a partir del correo
        $user = User::where('email', $request->email)->first();
    
        if (!$user) {
            return redirect()->back()->withErrors(['email' => 'El usuario no existe.']);
        }
    
        // Actualizar los datos en la tabla users
        $user->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'role_id' => 3, // Asegurar que el rol sea de empleado
        ]);
    
        // Crear el empleado en la tabla employees
        $employee = Employee::create([
            'business_id' => $businessId,
            'name' => $request->name,
            'email' => $user->email,
            'phone' => $request->phone,
            'position' => $request->position ?? null,
        ]);
    
        // Asociar al empleado con el negocio en la tabla 'business_user' si no está asociado
        $business = Business::findOrFail($businessId);
        if (!$business->users()->where('user_id', $user->id)->exists()) {
            $business->users()->attach($user->id, ['role_id' => 3]);
        }
    
        return redirect()->route('employees.index', ['user' => auth()->id()])
            ->with('success', 'Employee added successfully.');
    }

public function edit($businessId, $id)
{
    // Buscar el negocio
    $business = Business::findOrFail($businessId);
    
    // Buscar el empleado
    $employee = $business->users()
        ->where('users.role_id', 3)  // Especificar la columna role_id en la tabla users
        ->findOrFail($id);
    
    // Pasar el empleado a la vista
    return view('employees.edit', compact('employee', 'business'));
}

    public function update(Request $request, $businessId, $id)
    {
        $business = Business::findOrFail($businessId);
        $employee = $business->users()->where('users.id', $id)->where('users.role_id', 3)->firstOrFail();

        // Actualizar en la tabla users
        $employee->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        // También actualizar en la tabla employees
        Employee::where('business_id', $businessId)
            ->where('email', $employee->email) // Buscar por el email que se tenía antes de la actualización
            ->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
            ]);

        return redirect()->route('employees.index', ['user' => auth()->user()->id])->with('success', 'Employee updated successfully.');  
    }

    public function destroy(Business $business, User $employee)
    {
        // Buscar y eliminar el registro en la tabla employees
        Employee::where('business_id', $business->id)
            ->where('email', $employee->email) // Asegurar que se elimina el empleado correcto
            ->delete();
    
        $employee->businesses()->detach();
        $employee->update(['role_id' => 1]);
    
        return redirect()->route('employees.index', ['user' => auth()->id()])
            ->with('success', 'Employee deleted successfully.');
    }
}