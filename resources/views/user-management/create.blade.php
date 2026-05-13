<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add User') }}
        </h2>
    </x-slot>

    <div class="py-8 bg-[#f8fafc] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="space-y-6">
                <!-- Header -->
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h1 class="text-3xl font-black text-slate-950 tracking-tight">Add User</h1>
                        <p class="text-slate-500 font-semibold text-sm">Create a new user account</p>
                    </div>
                </div>

                <!-- Form Box -->
                <div class="bg-white rounded-3xl p-8 border border-slate-200/60 shadow-xl shadow-slate-200/30">
                    <form method="POST" action="{{ route('user-management.store') }}" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-black text-slate-600 uppercase tracking-wider mb-2">Name</label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" 
                                    class="w-full rounded-xl border border-slate-200 bg-slate-50 p-4 focus:ring-2 focus:ring-cyan-500 focus:border-transparent outline-none transition hover:bg-slate-100 cursor-pointer text-slate-950 font-medium" required>
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-black text-slate-600 uppercase tracking-wider mb-2">Email</label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}" 
                                    class="w-full rounded-xl border border-slate-200 bg-slate-50 p-4 focus:ring-2 focus:ring-cyan-500 focus:border-transparent outline-none transition hover:bg-slate-100 cursor-pointer text-slate-950 font-medium" required>
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="password" class="block text-sm font-black text-slate-600 uppercase tracking-wider mb-2">Password</label>
                                <input type="password" name="password" id="password" 
                                    class="w-full rounded-xl border border-slate-200 bg-slate-50 p-4 focus:ring-2 focus:ring-cyan-500 focus:border-transparent outline-none transition hover:bg-slate-100 cursor-pointer text-slate-950 font-medium" required>
                                @error('password')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="password_confirmation" class="block text-sm font-black text-slate-600 uppercase tracking-wider mb-2">Confirm Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" 
                                    class="w-full rounded-xl border border-slate-200 bg-slate-50 p-4 focus:ring-2 focus:ring-cyan-500 focus:border-transparent outline-none transition hover:bg-slate-100 cursor-pointer text-slate-950 font-medium" required>
                            </div>

                            <div class="md:col-span-2">
                                <label for="role" class="block text-sm font-black text-slate-600 uppercase tracking-wider mb-2">Role</label>
                                <select name="role" id="role" 
                                    class="w-full rounded-xl border border-slate-200 bg-slate-50 p-4 focus:ring-2 focus:ring-cyan-500 focus:border-transparent outline-none transition hover:bg-slate-100 cursor-pointer text-slate-950 font-medium" required>
                                    <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                </select>
                                @error('role')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex items-center justify-end pt-6 border-t border-slate-200 space-x-4">
                            <a href="{{ route('user-management.index') }}" class="px-6 py-3 text-slate-600 font-bold hover:text-slate-900 border border-slate-200 rounded-xl hover:bg-slate-50 transition-all duration-300 cursor-pointer">
                                Cancel
                            </a>
                            <button type="submit" class="bg-gradient-to-r from-blue-500 to-indigo-500 hover:from-blue-600 hover:to-indigo-600 text-white font-black py-3 px-8 rounded-xl transition-all duration-300 cursor-pointer hover:scale-105 hover:shadow-lg">
                                Create User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
