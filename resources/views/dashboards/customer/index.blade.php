<x-app-layout>
    <h1 class="text-2xl font-bold">Customer Dashboard</h1>
    <p>Welcome, {{ Auth::user()->name }}!</p>
    <!-- Show relevant info for a customer: upcoming appointments, etc. -->
</x-app-layout>