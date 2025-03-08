<x-app-layout>
    <h1 class="text-2xl font-bold text-blue-700">Business Dashboard</h1>
    <p class="text-blue-500">Welcome, {{ Auth::user()->name }}!</p>
        <!-- Show relevant info for a customer: upcoming appointments, etc. -->
</x-app-layout>