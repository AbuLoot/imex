@extends('layout')

@section('title_description', $page->title_description)

@section('meta_description', $page->meta_description)

@section('content')

  <main class="container main">

    <ol class="breadcrumb">
      <li><a href="/">Главная</a></li>
      <li class="active">{{ $page->title }}</li>
    </ol>

    <div class="row">
      <section class="col-md-offset-2 col-md-8">

        <h1 class="text-center">{{ $page->title }}</h1>

        {!! $page->content !!}

      </section>
    </div>
  </main>

@endsection