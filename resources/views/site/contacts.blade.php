@extends('layout')

@section('title_description', $page->title_description)

@section('meta_description', $page->meta_description)

@section('head')

@endsection

@section('content')

  <!-- Модальное окно -->
  @include('layouts.contact-us')

  <div class="container breadcrums">
    <ul>
      <li><a href="/">Главная</a></li>
      <li><a href="#">{{ $page->title }}</a></li>
    </ul>
  </div>

  <div class="container contacts"><!-- Контакты -->

    <h1>Контакты</h1>
    <div class="col-md-4 contacts-1">
      <div class="icon-img"><img src="img/dot.png" alt=""></div>
      <p>Республика Казахстан, г. Алматы,<br> проспект Райымбека, 165 а, офис 7</p>
    </div>
    <div class="col-md-4 contacts-1">
      <div class="icon-img"><img src="img/leter-big.png" alt=""></div>
      <p class="cont-address">toojapantrade@bk.ru</p>
    </div>
    <div class="col-md-4 contacts-1">
      <div class="icon-img"><img src="img/phone-big.png" alt=""></div>
      <span class="phones">
        <a href="tel:+77272797271">+7 727 279 72 71</a>
        <a class="after-del" href="tel:+77272797268">+7 727 279 72 68</a><br>
        <a href="tel:+77011118045">+7 701 111 80 45</a>
        <a href="tel:+77051118045">+7 705 111 80 45</a>
      </span>
    </div>
    <form action="/send-app" method="post" class="modal-form" id="contact-form">
      {{ csrf_field() }}
      <div class="modal-form-1">
        <div class="{{ $errors->has('name') ? ' has-error' : '' }}">
          <input type="text" placeholder="Имя *" name="name" id="name" value="{{ old('name') }}" minlength="2" maxlength="40" required>
          @if ($errors->has('name'))
            <span class="help-block text-danger">{{ $errors->first('name') }}</span>
          @endif
        </div>
        <div class="{{ $errors->has('phone') ? ' has-error' : '' }}">
          <input type="tel" placeholder="Телефона *" name="phone" id="phone" value="{{ old('phone') }}" minlength="5" maxlength="20" required>
          @if ($errors->has('phone'))
            <span class="help-block text-danger">{{ $errors->first('phone') }}</span>
          @endif
        </div>
        <div class="{{ $errors->has('email') ? ' has-error' : '' }}">
          <input type="email" placeholder="Email *" name="email" id="email" value="{{ old('email') }}" required>
          @if ($errors->has('email'))
            <span class="help-block text-danger">{{ $errors->first('email') }}</span>
          @endif
        </div>
      </div>
      <div class="modal-form-2">
        <textarea rows="8" placeholder="Сообщение" name="message" required="required"></textarea>
        <input type="submit" value="Отправить">
      </div>
    </form>
  </div><!-- Контакты -->
  <div class="map">
    <script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?sid=YCKALtUfTpPew5zOC9X-y8iMVMpTEjj3&amp;width=100%25&amp;height=567&amp;lang=ru_RU&amp;sourceType=constructor&amp;scroll=true"></script>
  </div>

  {!! $page->content !!}

@endsection
