@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">

    {{-- Breadcrumb & Title --}}
    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <nav class="flex items-center gap-2 text-on-surface-variant text-xs mb-2">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-primary">Dashboard</a>
                <span class="material-symbols-outlined text-sm">chevron_right</span>
                <span class="text-primary font-bold">Manajemen Pengguna</span>
            </nav>
            <h2 class="text-2xl font-bold text-on-surface flex items-center gap-2">
                <span class="material-symbols-outlined text-primary text-3xl">manage_accounts</span>
                Kelola Pengguna Sistem
            </h2>
            <p class="text-on-surface-variant text-sm mt-1">Kelola data akun pengguna, hak akses (Role), dan password pendaftar SPK BLT.</p>
        </div>
        <div>
            <a href="{{ route('users.create') }}" class="bg-primary hover:bg-primary-container text-on-primary px-5 py-2.5 rounded-xl font-semibold text-sm shadow-sm transition-all flex items-center gap-2">
                <span class="material-symbols-outlined text-sm">person_add</span>
                Tambah Pengguna Baru
            </a>
        </div>
    </div>

    {{-- Alert Messages --}}
    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 rounded-xl text-sm flex items-center gap-3 shadow-sm">
            <span class="material-symbols-outlined text-xl text-emerald-600">check_circle</span>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-4 bg-rose-50 border-l-4 border-rose-500 text-rose-800 rounded-xl text-sm flex items-center gap-3 shadow-sm">
            <span class="material-symbols-outlined text-xl text-rose-600">error</span>
            <span class="font-medium">{{ session('error') }}</span>
        </div>
    @endif

    {{-- Filter & Search Card --}}
    <div class="bg-white border border-outline-variant rounded-2xl p-4 shadow-sm mb-6">
        <form action="{{ route('users.index') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-center justify-between">
            <div class="flex flex-col md:flex-row gap-3 w-full md:w-auto flex-1">
                <div class="relative flex-1">
                    <span class="material-symbols-outlined absolute left-3.5 top-2.5 text-gray-400 text-lg">search</span>
                    <input type="text" name="search" value="{{ $search }}"
                           placeholder="Cari berdasarkan nama atau email..."
                           class="w-full pl-10 pr-4 py-2 border border-outline-variant rounded-xl text-sm focus:outline-none focus:border-primary">
                </div>
                <div class="w-full md:w-48">
                    <select name="role" class="w-full px-4 py-2 border border-outline-variant rounded-xl text-sm focus:outline-none focus:border-primary">
                        <option value="">Semua Role</option>
                        <option value="admin" {{ $role == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="user" {{ $role == 'user' ? 'selected' : '' }}>Pengguna Biasa (User)</option>
                    </select>
                </div>
            </div>
            <div class="flex items-center gap-2 w-full md:w-auto justify-end">
                <button type="submit" class="bg-primary text-on-primary px-4 py-2 rounded-xl text-sm font-semibold hover:bg-primary-container transition-all">
                    Filter
                </button>
                @if($search || $role)
                    <a href="{{ route('users.index') }}" class="px-4 py-2 border border-outline-variant text-gray-600 rounded-xl text-sm font-medium hover:bg-slate-50 transition-all">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- Users Table --}}
    <div class="bg-white border border-outline-variant rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 border-b border-gray-200 text-xs uppercase font-semibold text-gray-600">
                    <tr>
                        <th class="px-6 py-3.5">#</th>
                        <th class="px-6 py-3.5">Nama Pengguna</th>
                        <th class="px-6 py-3.5">Email</th>
                        <th class="px-6 py-3.5">Role</th>
                        <th class="px-6 py-3.5">Tanggal Terdaftar</th>
                        <th class="px-6 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($users as $index => $u)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="px-6 py-4 font-mono text-gray-500 text-xs">
                                {{ $users->firstItem() + $index }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold text-sm">
                                        {{ strtoupper(substr($u->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <span class="font-semibold text-gray-900 block">{{ $u->name }}</span>
                                        @if($u->id === auth()->id())
                                            <span class="text-[10px] bg-blue-100 text-blue-800 font-bold px-2 py-0.5 rounded-full">Akun Anda (Aktif)</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-700">
                                {{ $u->email }}
                            </td>
                            <td class="px-6 py-4">
                                @if($u->role === 'admin')
                                    <span class="inline-flex items-center gap-1 px-3 py-1 bg-purple-100 text-purple-800 border border-purple-200 rounded-full text-xs font-bold">
                                        <span class="material-symbols-outlined text-sm">admin_panel_settings</span> Administrator
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-3 py-1 bg-slate-100 text-slate-700 border border-slate-200 rounded-full text-xs font-medium">
                                        <span class="material-symbols-outlined text-sm">person</span> Pengguna Biasa
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-xs text-gray-500">
                                {{ $u->created_at ? $u->created_at->format('d M Y, H:i') : '-' }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('users.edit', $u->id) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Edit Akun">
                                        <span class="material-symbols-outlined text-lg">edit</span>
                                    </a>
                                    @if($u->id !== auth()->id())
                                        <form action="{{ route('users.destroy', $u->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-rose-600 hover:bg-rose-50 rounded-lg transition-colors" title="Hapus Akun">
                                                <span class="material-symbols-outlined text-lg">delete</span>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                                <span class="material-symbols-outlined text-4xl block mb-1 text-gray-300">no_accounts</span>
                                Tidak ada data pengguna yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="p-4 border-t border-gray-100">
                {{ $users->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
