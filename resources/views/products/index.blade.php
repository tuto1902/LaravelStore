@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @foreach($products as $product)
        <div class="col-xs-12 col-sm-6 col-md-3">
            <div class="thumbnail">
                <img src="http://via.placeholder.com/400x400" alt="" class="img-responsive">
                <div class="caption">
                    <div class="row">
                        <div class="col-md-12">
                            <h4>{{ $product->name }}</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4 col-sm-4 col-md-4">
                            <h3>${{ $product->getPrice() }}</h3>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <form action="/cart/{{ $product->getKey() }}" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('PUT') }}
                                @if($cart->hasItem($product->getKey()))
                                    <span>In Cart</span>
                                @else
                                    <button type="submit" class="btn btn-success" style="width: 100%">Add To Cart</button>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
