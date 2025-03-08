<x-app-layout>
    <h1 class="text-2xl font-bold">Edit Service: {{ $service->name }}</h1>

    <form action="{{ route('services.update', $service) }}" method="POST" class="mt-4">
        @csrf
        @method('PUT')

        <div>
            <label for="name">Service Name</label>
            <input type="text" name="name" id="name" value="{{ old('name', $service->name) }}" required>
            @error('name')
                <div class="text-red-600">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="description">Description (optional)</label>
            <textarea name="description" id="description">{{ old('description', $service->description) }}</textarea>
            @error('description')
                <div class="text-red-600">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="price">Price</label>
            <input type="number" step="0.01" name="price" id="price" value="{{ old('price', $service->price) }}" required>
            @error('price')
                <div class="text-red-600">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="duration">Duration (minutes)</label>
            <input type="number" name="duration" id="duration" value="{{ old('duration', $service->duration) }}" required>
            @error('duration')
                <div class="text-red-600">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 mt-2">Update Service</button>
    </form>
</x-app-layout>