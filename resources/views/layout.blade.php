<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title_description', 'IMEX TRD - ПРЯМЫЕ ОПТОВЫЕ ПОСТАВКИ ТОВАРОВ НАРОДНОГО ПОТРЕБЛЕНИЯ ИЗ ЯПОНИИ.')</title>
    <meta name="description" content="@yield('meta_description', 'imex.kz')">

    <link rel="icon" href="/img/favicon.png" sizes="16x16" type="image/png">
    <link rel="shortcut icon" href="/img/favicon.png" sizes="16x16" type="image/png">

    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400" rel="stylesheet">
    <link href="/bower_components/bootstrap/dist/css/bootstrap.css" rel="stylesheet">
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
    <nav class="navbar navbar-default">
      <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/">
            <img src="/img/logo.png" class="img-responsive">
          </a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Каталог <span class="caret"></span></a>
              <ul class="dropdown-menu">
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
            </li>
            @foreach ($pages as $page)
              <li><a href="/{{ $page->slug }}">{{ $page->title }}</a></li>
            @endforeach
          </ul>
          <ul class="nav navbar-nav navbar-right navbar-contacts">
            <li><a href="#"><span class="glyphicon glyphicon-earphone"></span> +7 (727) 2206241</a></li>
            <li><a href="#"><span class="glyphicon glyphicon-phone"></span> +7 (775) 2095404</a></li>
          </ul>
        </div>
      </div>
    </nav>


    @include('layouts.alerts')

    <!-- Content -->
    @yield('content')


    <footer class="footer">
      <div class="container">
        <div class="col-md-3 col-sm-6">
          <h3>Страницы</h3>
          <ul class="list-unstyled">
            @foreach ($pages as $page)
              @if (Request::is($page->slug, $page->slug.'/*'))
                <li><a class="active" href="/{{ $page->slug }}">{{ $page->title }}</a></li>
              @else
                <li><a href="/{{ $page->slug }}">{{ $page->title }}</a></li>
              @endif
            @endforeach
          </ul>
        </div>
        <div class="col-md-3 col-sm-6">
          <h3>Каталог</h3>
          <ul class="list-unstyled">
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
        <div class="col-md-3 col-sm-6">
          <h3>Прием заказов</h3>
          <ul class="list-unstyled">
            <li>В офисе с 9:00 - 18:00</li>
            <li>(Понедельник - Пятница)</li>
          </ul>
        </div>
        <div class="col-md-3 col-sm-6">
          <h3>Контакты</h3>
          <ul class="list-unstyled footer-contacts">
            <li><span class="glyphicon glyphicon-globe"></span> ТОО IMEX TRD</li>
            <li><span class="glyphicon glyphicon-map-marker"></span> г Алматы, ул Булкушева 9а</li>
            <li><span class="glyphicon glyphicon-earphone"></span> +7 (727) 2206241</li>
            <li><span class="glyphicon glyphicon-phone"></span> +7 (775) 2095404</li>
            <li><span class="glyphicon glyphicon-envelope"></span> imextrd17@gmail.com</li>
          </ul>
        </div>
      </div>
    </footer>
    <footer class="sub-footer">
      <div class="container">
        <div class="col-md-7">Права © <?php echo date('Y'); ?>. Сайт принадлежит «ТОО IMEX TRD»</div>
      </div>
    </footer>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    @yield('scripts')
  </body>
</html>