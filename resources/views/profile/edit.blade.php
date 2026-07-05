@extends('layouts.app')

@section('title', 'Edit Profil')

@section('content')

    {{-- Redirect to the custom profile page --}}
    @php
        header('Location: ' . route('profile.edit'));
        exit;
    @endphp

@endsection
