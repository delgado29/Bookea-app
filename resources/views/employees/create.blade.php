<x-app-layout>
    <h1 class="text-3xl font-bold mb-4 text-blue-700">Add New Employee</h1>

    <form action="{{ route('employees.store', ['business' => $business->id]) }}" method="POST">
        @csrf

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus class="block mt-1 w-full" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" type="email" name="email" value="{{ old('email') }}" required class="block mt-1 w-full" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="phone" :value="__('Phone')" />
            <x-text-input id="phone" type="text" name="phone" value="{{ old('phone') }}" required class="block mt-1 w-full" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="role" :value="__('Role')" />
            <select name="role_id" id="role" class="block mt-1 w-full">
                <option value="3" {{ old('role_id') == 3 ? 'selected' : '' }}>Employee</option>
            </select>
            <x-input-error :messages="$errors->get('role_id')" class="mt-2" />
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow">
                Add Employee
            </button>
        </div>
    </form>
</x-app-layout>