@extends('layouts.app')

@section('title', 'Edit Barang')
@section('subtitle', 'Perbarui data barang')

@section('content')
    @include('barangs._form', [
        'barang' => $barang,
        'action' => route('barangs.update', $barang),
        'method' => 'PUT',
        'submitLabel' => 'Perbarui Barang',
    ])
@endsection
