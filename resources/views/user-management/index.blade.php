<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Management') }}
        </h2>
    </x-slot>

    <div class="py-2 bg-[#f8fafc] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-2">
            
            <!-- Header Section -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-1">
                <div>
                    <h1 class="text-3xl font-black text-slate-950 tracking-tight">User Management</h1>
                    <p class="text-slate-500 font-semibold text-sm">Manage system users and permissions</p>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-1">
                <div class="bg-white rounded-3xl p-3 border border-slate-200/60 shadow-xl shadow-slate-200/30 relative overflow-hidden group hover:shadow-2xl transition-all duration-300 cursor-pointer hover:scale-[1.005] hover:-translate-y-0.5">
                    <div class="absolute top-0 right-0 p-2 opacity-10 group-hover:opacity-20 transition-opacity">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                    </div>
                    <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-1">Total Users</h3>
                    <p class="text-2xl font-black text-slate-950 tracking-tight">{{ $users->total() }}</p>
                </div>

                <div class="bg-white rounded-3xl p-3 border border-slate-200/60 shadow-xl shadow-slate-200/30 relative overflow-hidden group hover:shadow-2xl transition-all duration-300 cursor-pointer hover:scale-[1.005] hover:-translate-y-0.5">
                    <div class="absolute top-0 right-0 p-2 opacity-10 text-emerald-600 group-hover:opacity-20 transition-opacity">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <h3 class="text-xs font-black text-emerald-600/70 uppercase tracking-widest mb-1">Active Now</h3>
                    <p class="text-2xl font-black text-slate-950 tracking-tight">{{ $users->filter(fn($u) => $u->isOnline)->count() }}</p>
                </div>

                <div class="bg-white rounded-3xl p-3 border border-slate-200/60 shadow-xl shadow-slate-200/30 relative overflow-hidden group hover:shadow-2xl transition-all duration-300 cursor-pointer hover:scale-[1.005] hover:-translate-y-0.5">
                    <div class="absolute top-0 right-0 p-2 opacity-10 text-blue-600 group-hover:opacity-20 transition-opacity">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                    </div>
                    <h3 class="text-xs font-black text-blue-600/70 uppercase tracking-widest mb-1">Admins</h3>
                    <p class="text-2xl font-black text-slate-950 tracking-tight">{{ $users->filter(fn($u) => $u->role === 'admin')->count() }}</p>
                </div>
            </div>

            <!-- Main Content Box -->
            <div class="bg-white rounded-3xl p-3 border border-slate-200/60 shadow-xl shadow-slate-200/30">
                <div class="flex flex-wrap justify-between items-center gap-2 mb-2">
                    <h3 class="text-lg font-black text-slate-900">Recent Users</h3>
                    <div class="flex flex-wrap items-center gap-2">
                        <form method="GET" action="{{ route('user-management.index') }}" class="flex items-center gap-1">
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-4 w-4 text-slate-400 group-focus-within:text-cyan-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search Name or Email..." 
                                    class="pl-9 pr-4 py-2 border border-slate-200 rounded-xl focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 outline-none text-sm transition-all bg-slate-50/50 w-48 md:w-64">
                            </div>
                            <button type="submit" class="bg-slate-900 hover:bg-slate-800 text-white font-bold py-2 px-4 rounded-xl transition-all text-sm">
                                Search
                            </button>
                        </form>
                        <a href="{{ route('user-management.create') }}" class="bg-gradient-to-r from-cyan-500 to-blue-500 hover:from-cyan-600 hover:to-blue-600 text-white font-bold py-2 px-4 rounded-xl transition-all duration-300 cursor-pointer hover:scale-105 hover:shadow-lg flex items-center gap-2 text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Add New
                        </a>
                    </div>
                </div>

                <div class="overflow-x-auto min-h-[300px]">
                    <table class="min-w-full divide-y divide-gray-200 border">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-3 py-2 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="px-3 py-2 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Name</th>
                                <th class="px-3 py-2 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-3 py-2 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Role</th>
                                <th class="px-3 py-2 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-3 py-2 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Last Active</th>
                                <th class="px-3 py-2 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($users as $user)
                            <tr class="hover:bg-slate-50 transition-all duration-300 cursor-pointer hover:scale-[1.005]">
                                <td class="px-3 py-2 whitespace-nowrap text-sm font-medium text-gray-900">{{ $user->id }}</td>
                                <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500">{{ $user->name }}</td>
                                <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500">{{ $user->email }}</td>
                                <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500">
                                    <span class="px-2 py-0.5 text-xs font-semibold rounded-full {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500">
                                    <span class="inline-flex items-center gap-2">
                                        <span class="h-2 w-2 rounded-full {{ $user->isOnline ? 'bg-emerald-500 animate-pulse' : 'bg-slate-400' }}"></span>
                                        <span>{{ $user->isOnline ? 'Online' : 'Offline' }}</span>
                                    </span>
                                </td>
                                <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500">{{ optional($user->last_seen)->format('M d, H:i') ?? 'N/A' }}</td>
                                <td class="px-3 py-2 whitespace-nowrap text-sm font-medium">
                                    <form method="POST" action="{{ route('user-management.destroy', $user) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 font-bold transition-colors" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
