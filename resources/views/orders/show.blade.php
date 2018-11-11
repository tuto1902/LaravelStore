@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 text-center">
            <hr/>
            <h4>Success! Your order is confirmed</h4>
            <hr/>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title">
                        Products
                    </div>
                </div>
                <div class="panel-body">
                    @foreach($order->products as $product)
                        <div class="row">
                            <div class="col-md-2">
                                <img class="img-responsive" src="http://via.placeholder.com/100x70">
                            </div>
                            <div class="col-md-4">
                                <h4 class="product-name"><strong>{{ $product->name }}</strong></h4><h4><small>{{ $product->description }}</small></h4>
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-10 text-right">
                                    <h6>$<strong>{{ $product->getPrice() }}</strong></h6>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="panel-footer">
                    <div class="row text-center">
                        <div class="col-md-9">
                            <h4 class="text-right">Total <strong>${{ $order->totalPrice() }}</strong></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
