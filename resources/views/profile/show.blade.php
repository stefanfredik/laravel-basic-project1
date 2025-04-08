<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h5 class="text-lg font-semibold">My Profile</h5>
            <a href="{{ route('profile.edit') }}" class="px-3 py-1 bg-blue-600 text-white rounded text-sm hover:bg-blue-700">Edit Profile</a>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if (session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="flex flex-col md:flex-row">
                        <div class="md:w-1/3 text-center mb-4">
                            @if ($user->avatar)
                                <img src="{{ Storage::url($user->avatar) }}" class="w-40 h-40 rounded-full mx-auto object-cover">
                            @else
                                <div class="w-40 h-40 bg-gray-400 text-white rounded-full flex items-center justify-center mx-auto">
                                    <span class="text-5xl">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="md:w-2/3">
                            <div class="bg-white shadow overflow-hidden rounded-lg">
                                <div class="divide-y divide-gray-200">
                                    <div class="flex py-3 px-4">
                                        <div class="w-1/3 font-semibold text-gray-700">Name:</div>
                                        <div class="w-2/3">{{ $user->name }}</div>
                                    </div>
                                    <div class="flex py-3 px-4">
                                        <div class="w-1/3 font-semibold text-gray-700">Email:</div>
                                        <div class="w-2/3">{{ $user->email }}</div>
                                    </div>
                                    <div class="flex py-3 px-4">
                                        <div class="w-1/3 font-semibold text-gray-700">Phone:</div>
                                        <div class="w-2/3">{{ $user->phone ?? 'Not provided' }}</div>
                                    </div>
                                    <div class="flex py-3 px-4">
                                        <div class="w-1/3 font-semibold text-gray-700">Address:</div>
                                        <div class="w-2/3">{{ $user->address ?? 'Not provided' }}</div>
                                    </div>
                                    <div class="flex py-3 px-4">
                                        <div class="w-1/3 font-semibold text-gray-700">Member Since:</div>
                                        <div class="w-2/3">{{ $user->created_at->format('F d, Y') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <div class="flex justify-between">
                            <a href="{{ route('profile.change-password') }}" class="px-4 py-2 border border-blue-600 text-blue-600 rounded hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Change Password
                            </a>
                            
                            <button type="button" class="px-4 py-2 border border-red-600 text-red-600 rounded hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500" x-data x-on:click="$dispatch('open-modal', 'delete-account')">
                                Delete Account
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Account Modal -->
    <x-modal name="delete-account" focusable>
        <div class="p-6">
            <h2 class="text-lg font-semibold text-gray-900">Delete Account</h2>
            <p class="mt-2 text-red-600">Warning: This action cannot be undone. All your data will be permanently deleted.</p>
            
            <form method="POST" action="{{ route('profile.destroy') }}" class="mt-6">
                @csrf
                @method('DELETE')
                
                <div class="mt-6">
                    <label for="password" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                    <input type="password" id="password" name="password" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    @error('password')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="mt-6 flex justify-end">
                    <button type="button" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 mr-3"
                            x-on:click="$dispatch('close')">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Delete Account
                    </button>
                </div>
            </form>
        </div>
    </x-modal>
</x-app-layout>