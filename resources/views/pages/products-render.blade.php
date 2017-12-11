
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