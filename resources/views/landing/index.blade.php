@extends('layouts.landing')

@section('title', 'Beranda')

@section('content')

    @include('landing.sections.hero')
    @include('landing.sections.features')
    @include('landing.sections.workflow')

@endsection