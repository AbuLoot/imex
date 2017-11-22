@extends('layout')

@section('title_description', $page->title_description)

@section('meta_description', $page->meta_description)

@section('content')

    <section class="container content">
      <div class="row">
        <!-- Main -->
        <div class="col-md-12">
          <h1 class="content-title">Контакты</h1>
          <div class="panel panel-custom">
            <div class="col-md-4 how-to-find-us">
              <div class="row">
                <h2>Как нас найти?</h2>
                <br>
                <ul class="list-unstyled">
                  <li>Республика Казахстан</li>
                  <li>г Алматы, ул Булкушева 9а</li>
                </ul>
              </div>
            </div>
            <div class="col-md-8">
              <div class="row">
                <script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3A49b096b8434274906b19181b9790e19493f3d4cb4c949441dcc538ab3e5650e4&amp;width=100%25&amp;height=400&amp;lang=ru_RU&amp;scroll=false"></script>
              </div>
            </div>

            <div class="row">
              <div class="col-md-offset-3 col-md-6 form-app">
                <h2>Есть вопросы? Оставьте заявку!</h2>
                <form action="/agency/send-app" method="POST" enctype="multipart/form-data">
                  <input type="hidden" name="_token" value="WNgmpSg3cr8z7T7rRaZmPrnjZyjkN73ZSWHgW7aA">
                  <div class="form-group">
                    <input type="text" class="form-control input-lg" name="name" placeholder="Введите имя" minlength="2" maxlength="40" required>
                  </div>
                  <div class="form-group">
                    <input type="email" class="form-control input-lg" name="email" placeholder="Введите Email" minlength="5" maxlength="80" required>
                  </div>
                  <div class="form-group">
                    <input type="tel" class="form-control input-lg" name="phone" placeholder="Введите номер телефона" minlength="5" maxlength="20" required>
                  </div>
                  <div class="form-group">
                    <textarea name="text" class="form-control input-lg" rows="3" placeholder="Введите текст"></textarea>
                  </div>
                  <button type="submit" class="btn btn-default btn-lg btn-bordered">Отправить</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

@endsection
