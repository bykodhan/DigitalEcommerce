@extends('front.layouts.app')
@push('title', $page->title)
@section('content')
    <section class="py-3 bg-light ">
        <div class="container">
            <div class="page-header">
                <h2 class="page-title h3 mb-0">
                    {{ $page->title }}
                </h2>
            </div>
            <div class="row">
                <div class="col-lg-12 mx-auto mb-3">
                    {!! $page->content !!}
                </div>
            </div>
        </div>
    </section>
@endsection
