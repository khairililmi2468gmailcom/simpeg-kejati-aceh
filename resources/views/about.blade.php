@extends('layouts.app')

@section('title', 'About Page')

@section('content')
    <nav>
        <button hx-get="/" hx-target="#content" hx-push-url="true">Go to Home</button>
    </nav>

    <div id="content">
        <h1>About Us</h1>
        <p>This is the about page.</p>
    </div>
@endsection
