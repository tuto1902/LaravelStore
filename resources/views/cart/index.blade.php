@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="panel-title">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Shopping Cart</h5>
                            </div>
                            <div class="col-md-6">
                                <a href="/products" class="btn btn-primary btn-block">Continue Shopping</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    @foreach($cart->items as $item)
                    <div class="row">
                        <div class="col-md-2">
                            <img class="img-responsive" src="http://via.placeholder.com/100x70">
                        </div>
                        <div class="col-md-4">
                            <h4 class="product-name"><strong>{{ $item->product->name }}</strong></h4><h4><small>{{ $item->product->description }}</small></h4>
                        </div>
                        <div class="col-md-6">
                            <div class="col-md-10 text-right">
                                <h6>$<strong>{{ $item->product->getPrice() }}</strong></h6>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-link btn-xs">
                                    Remove
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="panel-footer">
                    <div class="row text-center">
                        <div class="col-md-9">
                            <h4 class="text-right">Total <strong>${{ $cart->totalPrice() }}</strong></h4>
                        </div>
                        <div class="col-md-3">
                            <form action="/orders" method="POST">
                                {{ csrf_field() }}
                                <script
                                        src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                        data-key="pk_test_f5pkrUrJ4xMmdgA8mLgUGHkD"
                                        data-amount="{{ $cart->getTotal() }}"
                                        data-name="Laravel Store"
                                        data-description="Test Purchase"
                                        data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                                        data-locale="auto">
                                </script>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection