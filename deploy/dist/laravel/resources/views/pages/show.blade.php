@extends('layouts.app')

@section('title', $page->meta_title ?? $page->title . ' - ' . config('app.name'))
@section('meta_description', $page->meta_description)
@section('meta_keywords', $page->meta_keywords)

@section('content')
@include('partials.page-header', [
    'title'    => $page->title,
    'subtitle' => $page->meta_description ?? null,
    'image'    => $page->featured_image_url ?? 'https://images.unsplash.com/photo-1625246333195-78d9c38ad449?auto=format&fit=crop&w=2000&q=80',
    'size'     => 'default',
    'overlay'  => true,
])

<!-- Content -->
<section class="py-16">
    <div class="container mx-auto px-4">
        <div class="max-w-5xl mx-auto">
            <style>
                .page-content figure figcaption { display: none !important; }
                .page-content figure { margin: 1rem 0; }
                .page-content figure img { border-radius: 0.5rem; max-width: 100%; height: auto; }
            </style>
            <div class="page-content prose prose-lg max-w-none prose-headings:text-gray-900 prose-p:text-gray-700 prose-a:text-cyan-600 hover:prose-a:text-cyan-700 prose-img:rounded-lg">
                {!! $page->rendered_content !!}
            </div>
        </div>
    </div>
</section>
@endsection
