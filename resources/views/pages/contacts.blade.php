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
                <form action="/send-app" method="POST" enctype="multipart/form-data">
                  {{ csrf_field() }}
                  <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <input type="text" class="form-control input-lg" name="name" placeholder="Введите имя" minlength="2" maxlength="40" value="{{ (old('name')) ? old('name') : '' }}" required>
                    @if ($errors->has('name'))
                      <span class="help-block">{{ $errors->first('name') }}</span>
                    @endif
                  </div>
                  <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <input type="email" class="form-control input-lg" name="email" placeholder="Введите Email" minlength="5" maxlength="80" value="{{ (old('email')) ? old('email') : '' }}" required>
                    @if ($errors->has('email'))
                      <span class="help-block">{{ $errors->first('email') }}</span>
                    @endif
                  </div>
                  <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                    <input type="tel" pattern="(\+?\d[- .]*){7,13}" class="form-control input-lg" name="phone" placeholder="Введите номер телефона" minlength="5" maxlength="20" value="{{ (old('phone')) ? old('phone') : '' }}" required>
                    @if ($errors->has('phone'))
                      <span class="help-block">{{ $errors->first('phone') }}</span>
                    @endif
                  </div>
                  <div class="form-group{{ $errors->has('site') ? ' has-error' : '' }}">
                    <input type="tel" class="form-control input-lg" name="site" placeholder="Введите веб-сайт" minlength="4" maxlength="50"value="{{ (old('site')) ? old('site') : '' }}" >
                    @if ($errors->has('site'))
                      <span class="help-block">{{ $errors->first('site') }}</span>
                    @endif
                  </div>
                  <div class="form-group">
                    <textarea name="message" class="form-control input-lg" rows="3" placeholder="Введите текст">{{ (old('text')) ? old('text') : '' }}</textarea>
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

@section('scripts')

  <!-- Message Status -->
  @if (session('alert'))
    <div class="modal fade" id="message-status" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title text-center">Статус заявки</h4>
          </div>
          <div class="modal-body">
            <p class="alert {{ session('alert') }}">{{ session('message') }}</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
          </div>
        </div>
      </div>
    </div>
    <script> $('#message-status').modal('show'); </script>
  @endif

@endsection