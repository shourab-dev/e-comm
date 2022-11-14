@extends('layouts.frontendapp')

@section('frontend')

<div class="container mt-5">
    <h1>User Dashboard</h1>
    <h2>Welcome to our Website Mr. {{ Auth::user()->name }}</h2>
</div>

@endsection