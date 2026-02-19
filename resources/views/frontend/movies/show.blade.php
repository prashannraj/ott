<!-- resources/views/frontend/movies/show.blade.php -->
@extends('frontend.layouts.app')

@section('title', $video->title)

@section('content')
    <div class="container py-5">
        <h1>{{ $video->title }}</h1>
        <p>{{ $video->description }}</p>
        <a href="{{ route('watch', $video->slug) }}" class="btn btn-danger">Watch Now</a>
        <h3>Related</h3>
        <x-frontend.components.movie-row :videos="$related" />
    </div>
@endsection