@extends('frontend.layouts.master')
@section('title', 'frontend page')
@section('frontend_content')
    @include('frontend.pages.widgets.slider')
    @include('frontend.pages.widgets.featured')
    @include('frontend.pages.widgets.countdown')
    @include('frontend.pages.widgets.best_seller')
    @include('frontend.pages.widgets.latest-product')
    @include('frontend.pages.widgets.testmonial')
@endsection
