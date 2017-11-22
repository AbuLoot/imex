<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title_description', 'SapaParts.kz')</title>
    <meta name="description" content="@yield('meta_description', 'SapaParts.kz')">

    <link rel="icon" href="/favicon.ico" type="image/x-icon" />
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />

    <!-- Bootstrap -->
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link href="/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/bower_components/typeahead.js/dist/typeahead.bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://d1azc1qln24ryf.cloudfront.net/114779/Socicon/style-cf.css?9177x2">
    <link href="/css/style.css" rel="stylesheet">
    @yield('head')

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <header>

      <!-- Menu -->
      <nav class="navbar navbar-default">
        <div class="container">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-navbar" aria-expanded="false">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand visible-xs-block" href="/">SapaParts</a>
          </div>

          <div class="collapse navbar-collapse" id="bs-navbar">
            <ul class="nav navbar-nav">
              @foreach ($pages as $page)
                <li><a href="/{{ $page->slug }}"><span class="glyphicon {{ $page->icon }}"></span> {{ $page->title }}</a></li>
              @endforeach
              <li><a href="#" class="order-products"><span class="glyphicon glyphicon-wrench"></span> Заказать запчасти</a></li>
              <li>
                <div class="social-buttons">Мы тут
                  <a href="#"><i class="socicon-google"></i></a>
                  <a href="#"><i class="socicon-facebook"></i></a>
                  <a href="#"><i class="socicon-vkontakte"></i></a>
                  <a href="#"><i class="socicon-instagram"></i></a>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </nav>

      <!-- Logo, search and cart -->
      <section class="logo-level">
        <div class="container">
          <div class="col-sm-4 col-md-4">
            <a href="/">
              <img src="/img/logo2.png" class="img-responsive">
            </a>
          </div>
          <div class="col-xs-8 col-sm-4 col-md-4 search">
            <form action="/search" method="get" class="row">
              <div class="input-group input-search">
                <input type="search" class="form-control input-lg typeahead-goods" name="text" placeholder="Поиск...">
                <span class="input-group-btn">
                  <button class="btn btn-default btn-lg" type="submit"><span class="glyphicon glyphicon-search"></span></button>
                </span>
              </div>
            </form>
          </div>
          <div class="col-md-offset-1 col-xs-4 col-sm-4 col-md-3 cart">
            <div class="dropdown">
              <a href="/basket" class="btn btn-default btn-lg btn-block">
                <span class="hidden-xs">Моя корзина</span>
                <span class="glyphicon glyphicon-shopping-cart"></span>
                <?php $items = session('items'); ?>
                <span class="badge" id="count-items"><?php echo (is_array($items)) ? count($items['products_id']) : 0; ?></span>
              </a>
            </div>
          </div>
        </div>
      </section>

      <!-- Navigation -->
      <nav class="navigation" id="navigation">
        <div class="container">
          <a class="btn btn-category btn-lg visible-xs-block" role="button" data-toggle="collapse" href="#collapseAutoParts" aria-expanded="false" aria-controls="collapseAutoParts"><span class="glyphicon glyphicon-menu-hamburger"></span> Запчасти</a>
          <ul class="nav nav-pills nav-justified collapse navigation-collapse categories" id="collapseAutoParts">
            <?php $traverse = function ($categories) use (&$traverse) { ?>
              <?php foreach ($categories as $category) : ?>
                <li>
                  <?php if (count($category->descendants()->get()) > 0) : ?>
                    <a>{{ $category->title }}</a>
                  <?php else : ?>
                    <a href="/catalog/{{ $category->slug }}">{{ $category->title }}</a>
                  <?php endif; ?>

                  <?php if ($category->children && count($category->children) > 0) : ?>
                    <ul class="subcategories">
                      <?php $traverse($category->children); ?>
                    </ul>
                  <?php endif; ?>
                </li>
              <?php endforeach; ?>
            <?php }; ?>
            <?php $traverse($categories); ?>
          </ul>
        </div>
      </nav>

    </header>

    @include('layouts.alerts')

    <!-- Content -->
    @yield('content')


    <!-- Footer -->
    <footer class="footer">
      <div class="container">
        <div class="col-md-3">
          <h4>Страницы</h4>
          <ul class="list-unstyled">
            @foreach ($pages as $page)
              @if (Request::is($page->slug, $page->slug.'/*'))
                <li class="active"><a href="/{{ $page->slug }}">{{ $page->title }}</a></li>
              @else
                <li><a href="/{{ $page->slug }}">{{ $page->title }}</a></li>
              @endif
            @endforeach
          </ul>
        </div>
        <div class="col-md-3">
          <h4>Мы в соц. сети.</h4>
          <ul class="list-unstyled">
            <li href="#"><i class="socicon-google"></i> <a href="#">Google +</a></li>
            <li href="#"><i class="socicon-facebook"></i> <a href="#">Facebook</a></li>
            <li href="#"><i class="socicon-vkontakte"></i> <a href="#">Vkontake</a></li>
            <li href="#"><i class="socicon-instagram"></i> <a href="#">Instagram</a></li>
          </ul>
        </div>
        <div class="col-md-6">
          <h4>Контакты</h4>
          <ul class="list-unstyled">
            <li>г. Алматы, ул. Райымбек</li>
            <li>+7 775 900 4204</li>
            <li>+7 707 900 4204</li>
            <li>info@sapaparts.kz</li>
          </ul>
        </div>

        <div class="col-md-12"><br>
          <p class="text-center">SapaParts 2015 - {{ date('Y') }}</p>
        </div>
      </div>
    </footer>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script> -->
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="/bower_components/typeahead.js/dist/typeahead.bundle.min.js"></script>
    <!-- Typeahead Initialization -->
    <script>
      jQuery(document).ready(function($) {
        // Set the Options for "Bloodhound" suggestion engine
        var engine = new Bloodhound({
          remote: {
            url: '/search-ajax?text=%QUERY%',
            wildcard: '%QUERY%'
          },
          datumTokenizer: Bloodhound.tokenizers.whitespace('text'),
          queryTokenizer: Bloodhound.tokenizers.whitespace
        });

        $(".typeahead-goods").typeahead({
          hint: true,
          highlight: true,
          minLength: 2
        }, {
          limit: 10,
          source: engine.ttAdapter(),
          displayKey: 'title',

          templates: {
            empty: [
              '<li>&nbsp;&nbsp;&nbsp;Ничего не найдено.</li>'
            ],
            suggestion: function (data) {
              return '<li><a href="/goods/' + data.id + '-' + data.slug + '"><img class="list-img" src="/img/products/' + data.path + '/' + data.image + '"> ' + data.title + '<br><span>Код: ' + data.barcode + '</span> <span>ОЕМ: ' + data.oem + '</span></a></li>'
            }
          }
        });
      });
    </script>
    @yield('scripts')
  </body>
</html>
