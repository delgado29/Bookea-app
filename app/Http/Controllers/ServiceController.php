<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Business;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->role->name !== 'business_admin') {
            abort(403, 'Unauthorized action.');
        }
        // Example: if each business_admin owns exactly one business,
        // we can do:
        $business = auth()->user()->ownedBusinesses->first();
    
        // If there's no business, show an empty list or handle accordingly
        if (!$business) {
            return view('services.index', ['services' => []]);
        }
    
        // Fetch the services for that business
        $services = $business->services; // because of $business->hasMany(Service::class)
    
        return view('services.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // If you want to let admin pick from multiple businesses, fetch them:
        // $businesses = auth()->user()->ownedBusinesses;
        if (auth()->user()->role->name !== 'business_admin') {
            abort(403, 'Unauthorized action.');
        }
        return view('services.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (auth()->user()->role->name !== 'business_admin') {
            abort(403, 'Unauthorized action.');
        }
        // Validate the incoming data
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'duration' => 'required|integer',
        ]);
    
        // Retrieve the business that the admin owns
        $business = auth()->user()->ownedBusinesses->first();
        if (!$business) {
            return redirect()->route('services.index')
                ->with('error', 'You do not have a business to create services for.');
        }
    
        // Create the service
        $service = $business->services()->create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'duration' => $request->duration,
        ]);
    
        return redirect()->route('services.index')
            ->with('success', 'Service created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        if (auth()->user()->role->name !== 'business_admin') {
            abort(403, 'Unauthorized action.');
        }
        // Optional: verify $service->business_id belongs to the current user
        if ($service->business->owner_id !== auth()->id()) {
            abort(403);
        }
        return view('services.show', compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        if (auth()->user()->role->name !== 'business_admin') {
            abort(403, 'Unauthorized action.');
        }
        // Ensure the service belongs to the business admin
        if ($service->business->owner_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }
    
        return view('services.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        if (auth()->user()->role->name !== 'business_admin') {
            abort(403, 'Unauthorized action.');
        }
        // Security check
        if ($service->business->owner_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }
    
        // Validate new data
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'duration' => 'required|integer',
        ]);
    
        // Update the service
        $service->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'duration' => $request->duration,
        ]);
    
        return redirect()->route('services.index')
            ->with('success', 'Service updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        // Check ownership
        if ($service->business->owner_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }
    
        $service->delete();
    
        return redirect()->route('services.index')
            ->with('success', 'Service deleted successfully!');
    }
}
