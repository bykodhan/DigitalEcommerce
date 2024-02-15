@extends('front.layouts.app')
@push('title', $article->title)
@push('description', $article->description)
@push('og_image',asset($article->img))
@section('content')
    <section class="py-3 bg-light">
        <div class="container">
            <div class="page-header">
                <h2 class="page-title h3 mb-0">
                    {{ $article->title }}
                </h2>
            </div>
            <div class="row">
                <div class="col-lg-6 mx-auto mb-3">
                    <img src="{{ asset($article->img) }}" class="img-fluid" alt="{{$article->title}}">
                </div>
                <div class="col-lg-12 mx-auto mb-3">
                    {!! $article->content !!}
                </div>
            </div>
        </div>
    </section>
@endsection
