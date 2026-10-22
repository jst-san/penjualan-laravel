@extends('layouts.app')

@section('title', 'Edit User')
@section('subtitle', 'Perbarui data pengguna')

@section('content')
    @include('users._form', [
        'user' => $user,
        'roles' => $roles,
        'action' => route('users.update', $user),
        'method' => 'PUT',
        'submitLabel' => 'Perbarui User',
    ])
@endsection
