@extends('layout')

@section('title_description', $page->title_description)

@section('meta_description', $page->meta_description)

@section('content')

    <section class="container content">
      <!-- Main -->
      <h1 class="content-title">{{ $page->title }}</h1>

        @foreach ($companies->chunk(4) as $chunk)
          <div class="row">
            @foreach ($chunk as $company)
              <div class="col-md-3">
                <div class="thumbnail">
                  <img src="/img/companies/{{ $company->logo }}" alt="..." class="img-responsive"><br>
                </div>
              </div>
            @endforeach
          </div><br>
        @endforeach
    </section>

@endsection
