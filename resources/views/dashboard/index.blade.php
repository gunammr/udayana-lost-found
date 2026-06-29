@extends('layouts.app')

@section('title','Dashboard')

@section('content')

    @include('dashboard.sections.header')
    @include('dashboard.sections.summary')
    @include('dashboard.sections.quick-access')
    @include('dashboard.sections.information')

@endsection