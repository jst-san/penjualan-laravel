@extends('layouts.app')

@section('title', 'Tambah Barang')
@section('subtitle', 'Lengkapi data barang baru')

@section('content')
    @include('barangs._form', [
        'action' => route('barangs.store'),
        'method' => 'POST',
        'submitLabel' => 'Simpan Barang',
    ])
@endsection
