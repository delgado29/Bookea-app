<x-app-layout>
    <h1 class="text-3xl font-bold mb-4 text-blue-700 ">Services</h1>

    @if(session('success'))
        <div class="p-3 mb-4 bg-green-200 text-green-800 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('services.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg shadow">
        + Create New Service
    </a>

    <div class="overflow-x-auto mt-6">
        <table class="w-full border-collapse border border-gray-300 shadow-lg">
            <thead>
                <tr class="bg-gray-100 text-gray-700 uppercase text-sm">
                    <th class="border border-gray-300 px-4 py-2 text-left">Name</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Description</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Price</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Duration</th>
                    <th class="border border-gray-300 px-4 py-2 text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($services as $service)
                    <tr class="border border-gray-300 hover:bg-gray-50">
                        <td class="text-blue-500 px-4 py-2">{{ $service->name }}</td>
                        <td class="text-blue-500 px-4 py-2">{{ $service->description }}</td>
                        <td class="text-blue-500 px-4 py-2">${{ number_format($service->price, 2) }}</td>
                        <td class="text-blue-500 px-4 py-2">{{ $service->duration }} mins</td>
                        <td class="text-blue-500 px-4 py-2 flex justify-center space-x-2">
                            <a href="{{ route('services.edit', $service) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-lg text-sm shadow">
                                Edit
                            </a>
                            <form action="{{ route('services.destroy', $service) }}" method="POST" onsubmit="return confirm('Delete this service?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg text-sm shadow">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-gray-500 py-4">No services found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>