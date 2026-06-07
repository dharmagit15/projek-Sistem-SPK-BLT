@extends('layouts.app')

@section('content')
<div class="mb-8">
    <h2 class="text-2xl font-bold text-slate-800">Selamat Datang, Admin</h2>
</div>

<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm">
        <p class="text-[11px] text-slate-500 uppercase font-semibold">Total Kriteria</p>
        <h3 class="text-2xl font-bold text-slate-800">{{ $totalKriteria }}</h3>
    </div>
</div>
@endsection