@extends('layout')

@section('content')

    <!-- Slides -->
    <section id="carousel-trucks" class="carousel slide" data-ride="carousel">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        <li data-target="#carousel-trucks" data-slide-to="0" class="active"></li>
        <li data-target="#carousel-trucks" data-slide-to="1"></li>
      </ol>

      <div class="carousel-inner" role="listbox">
        <div class="item active">
          <img src="img/bg1.png" class="center-block" alt="...">
          <div class="carousel-caption">
            <h1>Магазин запчастей "SapaParts" в Казахстане</h1>
            <p class="short-description"></p>
            <img src="img/arrow-down.png" class="arrow-down">
          </div>
        </div>
        <div class="item">
          <img src="img/bg3.png" class="center-block" alt="...">
          <div class="carousel-caption">
            <h1>Магазин запчастей "SapaParts" в Казахстане</h1>
            <p class="short-description"></p>
            <img src="img/arrow-down.png" class="arrow-down">
          </div>
        </div>
      </div>
    </section>

    <!-- New products -->
    <section class="new-products">
      <div class="container">

        <h2>Новые товары</h2>

        <article id="new_products" class="carousel slide" data-ride="carousel" data-interval="false">
          <div class="carousel-inner" role="listbox">

            <!-- Carousel control -->
            <div class="products-control" role="group" aria-label="...">
              <a class="left-arrow" href="#new_products" data-slide="prev"><span class="glyphicon glyphicon-menu-left"></span></a>
              <a class="right-arrow" href="#new_products" data-slide="next"><span class="glyphicon glyphicon-menu-right"></span></a>
            </div>

            @foreach ($new_products->chunk(3) as $key => $chunk)
              <div class="item @if($key == '0') active @endif">
                <div class="col-xs-offset-1 col-sm-offset-1 col-md-offset-1 col-xs-10 col-sm-10 col-md-10 products-chunk" id="chunk">
                  @foreach ($chunk as $new_product)
                    <div class="col-sm-4 col-md-4">
                      <a href="/goods/{{ $new_product->id.'-'.$new_product->slug }}">
                        <img class="img-responsive center-block" src="/img/products/{{ $new_product->path . '/' . $new_product->image }}" alt="{{ $new_product->title }}">
                      </a>
                      <div class="caption text-center">
                        <h4><a href="/goods/{{ $new_product->id.'-'.$new_product->slug }}">{{ $new_product->title }}</a></h4>
                        <p>{{ $new_product->price }} 〒</p>
                      </div>
                    </div>
                  @endforeach
                </div>
              </div>
            @endforeach
          </div>
        </article>
      </div>
    </section>

    <!-- Brands -->
    <section class="brands">
      <div class="container">
        <h2>Партнеры</h2>
        <ul class="brands-logo nav-justified list-unstyled">
          @foreach ($companies as $company)
            <li><a href="#"><img src="/img/companies/{{ $company->logo }}" class="center-block img-responsive"></a><br></li>
          @endforeach
        </ul>
      </div>
    </section>

    <!-- Last products -->
    <section class="last-products">
      <div class="container">

        <h3 class="h2">Последние товары</h3>

        <article id="last_products" class="carousel slide" data-ride="carousel" data-interval="false">
          <div class="carousel-inner" role="listbox">

            <!-- Carousel control -->
            <div class="products-control" role="group" aria-label="...">
              <a class="left-arrow" href="#last_products" data-slide="prev"><span class="glyphicon glyphicon-menu-left"></span></a>
              <a class="right-arrow" href="#last_products" data-slide="next"><span class="glyphicon glyphicon-menu-right"></span></a>
            </div>

            @foreach ($last_products->chunk(3) as $key => $chunk)
              <div class="item @if($key == '0') active @endif">
                <div class="col-xs-offset-1 col-sm-offset-1 col-md-offset-1 col-xs-10 col-sm-10 col-md-10 products-chunk" id="chunk">
                  @foreach ($chunk as $last_product)
                    <div class="col-sm-4 col-md-4">
                      <a href="/goods/{{ $last_product->id.'-'.$last_product->slug }}">
                        <img class="img-responsive" src="/img/products/{{ $last_product->path . '/' . $last_product->image }}" alt="{{ $last_product->title }}">
                      </a>
                      <div class="caption text-center">
                        <h4><a href="/goods/{{ $last_product->id.'-'.$last_product->slug }}">{{ $last_product->title }}</a></h4>
                        <p>{{ $last_product->price }} 〒</p>
                      </div>
                    </div>
                  @endforeach
                </div>
              </div>
            @endforeach
          </div>
        </article>
      </div>
    </section>

@endsection

@section('scripts')
  <script>
    function addToBasket(i) {

      var productId = $(this).data("id");

      if (productId != '') {
        $.ajax({
          type: "get",
          url: '/add-to-basket/'+productId,
          dataType: "json",
          data: {},
          success: function(data) {
            console.log(data);
            $('*[data-id="'+productId+'"]').replaceWith('<a href="/basket" class="btn btn-basket" data-toggle="tooltip" data-placement="top" title="Перейти в корзину"><img src="/img/shopping-cart.png"></a>');
            $('#count-items').text(data.countItems);
            alert('Товар добавлен в корзину');
          }
        });
      } else {
        alert("Ошибка сервера");
      }
    }

    $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    })
  </script>
@endsection
