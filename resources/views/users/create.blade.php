@extends('layouts.app')

@section('title', 'Tambah User')
@section('subtitle', 'Buat akun pengguna baru')

@section('content')
    @include('users._form', [
        'roles' => $roles,
        'action' => route('users.store'),
        'method' => 'POST',
        'submitLabel' => 'Simpan User',
    ])
@endsection
