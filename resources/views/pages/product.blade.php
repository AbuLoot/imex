@extends('layout')

@section('title_description', $product->title_description)

@section('meta_description', $product->meta_description)

@section('content')

    <section class="container content">
      <div class="row">
        <div class="col-md-3">
          <aside class="categories">
            <!-- <img src="/img/sticker.png" class="img-responsive"> -->
            <h3>Категории</h3>
            <ul class="categories-menu">
              <?php $traverse = function ($categories) use (&$traverse) { ?>
                <?php foreach ($categories as $category) : ?>
                  <?php if (count($category->descendants()->get()) > 0) : ?>
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
        </div>

        <!-- Main -->
        <div class="col-md-9">
          <h1 class="content-title">{{ $product->category->title }}</h1>
          <div class="panel panel-custom">
            <ol class="breadcrumb">
              <li><a href="/">Главная</a></li>
              <li><a href="/catalog/{{ $product->category->slug }}">{{ $product->category->title }}</a></li>
              <li class="active">{{ $product->title }}</li>
            </ol>
            <div class="panel-body">
              <div class="row">

                <div class="col-md-5">
                  @if ($product->images != '')
                    <?php $images = unserialize($product->images); ?>
                    @foreach ($images as $k => $image)
                      <div class="thumbnail">
                        <img src="/img/products/{{ $product->path.'/'.$images[$k]['image'] }}" class="img-responsive" alt="{{ $product->title }}">
                      </div>
                    @endforeach
                  @else
                    <div class="thumbnail">
                      <img src="/img/no-image-big.png" class="img-responsive">
                    </div>
                  @endif
                </div>
                <div class="col-md-7">
                  <h2>{{ $product->title }}</h2>
                  <table class="table">
                    <tbody>
                      <tr>
                        <td>Артикул:</td>
                        <td>{{ $product->barcode }}</td>
                      </tr>
                      <tr>
                        <td>Производитель:</td>
                        <td>{{ $product->company->title }}</td>
                      </tr>
                      <tr>
                        <td>Объем:</td>
                        <td>{{ strip_tags($product->characteristic) }}</td>
                      </tr>
                    </tbody>
                  </table>

                  {!! $product->description !!}
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

@endsection
