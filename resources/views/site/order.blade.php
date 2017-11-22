@extends('layout')

@section('content')

  <!-- Модальное окно -->
  @include('layouts.contact-us')

  <div class="container breadcrums">
    <ul>
      <li><a href="/">Главная</a></li>
      <li><a href="/basket">Корзина</a></li>
      <li><a href="#">Оформление заказа</a></li>
    </ul>
  </div>

  <div class="container">

    <h1>Оформление заказа</h1>
    <div class="col-md-8 panel panel-default">
      <div class="panel-body">
        <form action="/order" method="post" class="well" id="order-form">
          {{ csrf_field() }}
          <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
            <label for="name">Имя</label>
            <input type="text" class="form-control" placeholder="Имя *" name="name" id="name" value="{{ old('name') }}" minlength="2" maxlength="40" required>
            @if ($errors->has('name'))
              <span class="help-block text-danger">{{ $errors->first('name') }}</span>
            @endif
          </div>
          <div class="form-group {{ $errors->has('phone') ? ' has-error' : '' }}">
            <label for="phone">Телефона</label>
            <input type="tel" class="form-control" placeholder="Телефона *" name="phone" id="phone" value="{{ old('phone') }}" minlength="5" maxlength="20" required>
            @if ($errors->has('phone'))
              <span class="help-block text-danger">{{ $errors->first('phone') }}</span>
            @endif
          </div>
          <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
            <label for="email">Email</label>
            <input type="email" class="form-control" placeholder="Email *" name="email" id="email" value="{{ old('email') }}" required>
            @if ($errors->has('email'))
              <span class="help-block text-danger">{{ $errors->first('email') }}</span>
            @endif
          </div>
          <div class="form-group">
            <label for="city_id">Регион</label>
            <select id="city_id" name="city_id" class="form-control">
              <option value=""></option>
              @foreach($countries as $country)
                <optgroup label="{{ $country->title }}">
                  @foreach($country->cities as $city)
                    <option value="{{ $city->id }}">{{ $city->title }}</option>
                  @endforeach
                </optgroup>
              @endforeach
            </select>
          </div>
          <div class="form-group {{ $errors->has('address') ? ' has-error' : '' }}">
            <label for="address">Адрес</label>
            <input type="text" class="form-control" placeholder="Адрес *" name="address" id="address" value="{{ old('address') }}" minlength="2" maxlength="40" required>
            @if ($errors->has('address'))
              <span class="help-block text-danger">{{ $errors->first('address') }}</span>
            @endif
          </div>

          <div class="table-responsive">
            <table class="table table-striped table-condensed">
              <thead>
                <tr class="active">
                  <td>Название</td>
                  <td>Цена</td>
                  <td>Количество</td>
                </tr>
              </thead>
              <tbody>
                @foreach ($products as $product)
                  <tr>
                    <td>
                      <img src="/img/products/{{ $product->path.'/'.$product->image }}" style="width:80px;height:80px;">
                      <a href="/catalog/{{ $product->category->slug.'/'.$product->slug }}">{{ $product->title }}</a>
                    </td>
                    <td>{{ $product->price }}</td>
                    <td></td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>

          <p>Итого: <b>{{ $products->sum('price') }} ₸</b></p>
          <button type="submit" class="btn btn-primary text-uppercase">Заказать</button>
        </form>
      </div>
    </div>
    <div class="col-md-4">
      <h4>Служба доставки</h4>
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">Курьерская доставка</h3>
        </div>
        <div class="panel-body">Доставка товара осуществляется в течении дня после оформления заявки или в другое удобное для вас время с 10 до 18 часов, только после подтверждения заказа менеджером интернет–магазина. </div>
      </div>
      <h4>Виды оплаты:</h4>
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">Оплата наличными при получении заказа</h3>
        </div>
        <div class="panel-body">Вместе с товаром вы получите сопутствующие документы:  товарный чек, гарантия (если товар является гарантийным).</div>
      </div>
    </div>
  </div>

@endsection
