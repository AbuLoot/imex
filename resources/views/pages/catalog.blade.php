@extends('layout')

@section('title_description', $category->title_description)

@section('meta_description', $category->meta_description)

@section('content')

    <section class="container content">
      <div class="row">
        <div class="col-md-3 col-xs-12">
          <aside class="categories">
            <!-- <img src="/img/sticker.png" class="img-responsive"> -->
            <h3 class="text-uppercase">Категории</h3>
            <ul class="categories-menu">
              <?php $traverse = function ($categories) use (&$traverse) { ?>
                <?php foreach ($categories as $category) : ?>
                  <?php if ($category->descendants->count() > 0) : ?>
                    <li class="dropdown-submenu">
                      <a href="/catalog/{{ $category->slug }}">{{ $category->title }} <span class="glyphicon glyphicon-menu-right text-right"></span></a>
                      <?php if ($category->children && count($category->children) > 0) : ?>
                        <ul class="dropdown-menu dropdown-custom">
                          <?php $traverse($category->children); ?>
                        </ul>
                      <?php endif; ?>
                    </li>
                  <?php else : ?>
                    <li>
                      <a href="/catalog/{{ $category->slug }}">{{ $category->title }}</a>
                    </li>
                  <?php endif; ?>
                <?php endforeach; ?>
              <?php }; ?>
              <?php $traverse($categories); ?>
            </ul>
          </aside>

          <form action="/filter-products" method="get" id="filter">
            <ul class="list-group">
              <li class="list-group-item">
                <h4 class="text-uppercase text-center">По брендам</h4>
              </li>
              @foreach ($companies as $company)
                <li class="list-group-item">
                  <label>
                    <input type="checkbox" name="companies_id[]" value="{{ $company->id }}"> &nbsp;&nbsp;{{ $company->title }}
                  </label>
                </li>
              @endforeach
            </ul>
          </form>
        </div>

        <!-- Main -->
        <div class="col-md-9 col-xs-12">
          <h1 class="content-title">{{ $category->title }}</h1>
          <?php if ($category->children && count($category->children) > 0) : ?>
            <ul class="list-inline">
              <?php foreach ($category->children as $child_category) : ?>
                <li><a href="/catalog/{{ $child_category->slug }}">{{ $child_category->title }}</a></li>
              <?php endforeach; ?>
            </ul><br>
          <?php endif; ?>

          <div id="products">
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
      </div>
    </section>

@endsection


@section('scripts')
  <script>
    // Filter products
    $('#filter').on('click', 'input', function(e) {
      var companiesId = new Array();
      var page = $(location).attr('href').split('catalog')[1];
      $('input[name="companies_id[]"]:checked').each(function() {
        companiesId.push($(this).val());
      });
      if (companiesId.length > 0) {
        $.ajax({
          type: "get",
          url: '/catalog' + page,
          dataType: "json",
          data: {
            "companies_id": companiesId
          },
          success: function(data) {
            $('#products').html(data);
          }
        });
      } else {
        $.ajax({
          type: "get",
          url: '/catalog' + page,
          dataType: "json",
          success: function(data) {
            $('#products').html(data);
          }
        });
      }
    });

    $("body").on('click', '.pagination a', function(e) {
      e.preventDefault();
      var page = $(this).attr('href').split('catalog')[1];
      var companiesId = $('input[name="companies_id[]"]:checked').map(function(){
            return this.value
        }).get();
      $.ajax({
        url : '/catalog' + page,
        dataType: 'json',
        data: {
          'companies_id': companiesId
        }
      }).done(function (data) {
        $('#products').html(data);
        $('html, body').animate({ scrollTop: $('#products').offset().top }, 1000);
      }).fail(function () {
        alert('Продукты не загрузились');
      });
    });
  </script>
@endsection