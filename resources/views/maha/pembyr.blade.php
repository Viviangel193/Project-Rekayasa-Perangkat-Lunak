@extends('layouts.mainMhs')

@section('title', 'Pembayaran')

@section('content')
<div class="flex justify-center items-center mb-6">
    <div class="text-center">
        <form action="{{ route('maha.detail') }}" method="POST">
            @csrf
            <div class="bg-blue-700 p-10 rounded-lg inline-block" style="width: 400px;">
                <label class="block text-white mb-2">Nomor Virtual Account</label>
                <input class="w-full p-2 rounded bg-blue-500 text-white placeholder-white"
                       placeholder="Input No VA"
                       type="text"
                       name="no_va"
                       required>
            </div>
            <div class="mt-6">
                <button type="submit" class="bg-blue-700 text-white px-6 py-2 rounded">LANJUTKAN</button>
            </div>
        </form>
        @if (session('error'))
            <div class="bg-red-600 text-white mt-4 p-2 rounded">
                {{ session('error') }}
            </div>
        @endif
    </div>
</div>
@endsection
