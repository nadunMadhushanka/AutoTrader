@extends('includes.app')

@section('content')

<div class="container">
    <div class="row justify-content">
        <div class="col-md-12">
            <div class="card p-3 ">
                <h5 class="card-header bg-success text-white">Create a record</h5>
                <form class="form-inline" action="/set-record" method="post">
                    {{ csrf_field() }}
                    <br>
                    <input placeholder="enter the leverage" class="form-control" type="text"name="lev">
                    <br>
                    <select class="form-control" name="symbol">
                        <option selected disabled name="" id="">select a currency pair</option>
                        @foreach ($currpair as $item)
                            <option value="{{ $item->name }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                    <br>
                    <select class="form-control" name="side">
                        <option selected disabled value="">Select the side</option>
                            <option value="Buy">Buy</option>
                            <option value="Sell">Sell</option>
                    </select>
                    <br>
                    
                    <input placeholder="Enter the order price" class="form-control" type="text" name="price">
                    <br>
                    <input placeholder="Enter the quantity" class="form-control" type="text" name="qty">
                    <br>
                    
                    <input class="btn btn-success" type="submit" value="Save record">
                </form>
            </div>
        </div>

    </div>
</div>

@endsection