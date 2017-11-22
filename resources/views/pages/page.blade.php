@extends('layout')

@section('title_description', $page->title_description)

@section('meta_description', $page->meta_description)

@section('content')

    <section class="container content">
      <div class="row">
        <!-- Main -->
        <div class="col-md-offset-2 col-md-8">
          <div class="panel panel-custom">
            <div class="panel-body">
              <h1 class="content-title">{{ $page->title }}</h1>

              {!! $page->content !!}

            </div>
          </div>
        </div>
      </div>
    </section>

@endsection
