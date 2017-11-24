@extends('layout')

@section('title_description', $category->title_description)

@section('meta_description', $category->meta_description)

@section('content')

    <section class="container content">
      <div class="row">
        <div class="col-md-3">
          <aside class="categories">
            <img src="/img/sticker.png" class="img-responsive">
            <h3>Категории</h3>
            <div class="list-group">
              <?php $traverse = function ($categories) use (&$traverse) { ?>
                <?php foreach ($categories as $category) : ?>
                  <?php if (count($category->descendants()->get()) > 0) : ?>
                    <a class="list-group-item">{{ $category->title }}</a>
                  <?php else : ?>
                    <a href="/catalog/{{ $category->slug }}" class="list-group-item">{{ $category->title }}</a>
                  <?php endif; ?>

                  <?php if ($category->children && count($category->children) > 0) : ?>
                    <div class="list-group">
                      <?php $traverse($category->children); ?>
                    </div>
                  <?php endif; ?>
                <?php endforeach; ?>
              <?php }; ?>
              <?php $traverse($categories); ?>
            </div>
          </aside>
        </div>

        <!-- Main -->
        <div class="col-md-9">
          <h1 class="content-title">{{ $category->title }}</h1>

          @foreach ($products->chunk(4) as $chunk)
            <div class="row products">
              @foreach ($chunk as $product)
                <div class="col-md-3 col-xs-6">
                  <div class="thumbnail">
                    <a href="/goods/{{ $product->id . '-' . $product->slug }}"><img src="/img/products/{{ $product->path.'/'.$product->image }}" alt="{{ $product->title }}"></a>
                    <div class="caption">
                      <h5><a href="/goods/{{ $product->id . '-' . $product->slug }}">{{ $product->title }}</a></h5>
                      <!-- <a href="#" class="btn btn-link" role="button">Button</a> -->
                    </div>
                  </div>
                </div>
              @endforeach
            </div><br>
          @endforeach

          <!-- Pagination -->
          <nav class="text-center" aria-label="Page navigation">
            {{ $products->links() }}
          </nav>
        </div>
      </div>
    </section>

@endsection
