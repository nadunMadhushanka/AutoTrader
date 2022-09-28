@extends('includes.app')

@section('content')

<div class="container">
    <div class="position-relative row justify-content-center">
        <div class="position-absolute col-md-8">
            <div class="card p-3 ">
                <h5 class="card-header bg-success text-white">Create a record</h5>
                <form class="form-inline" action="/set-record" method="post">
                    {{ csrf_field() }}
                    <br>
                    <br>
                    <input placeholder="enter the leverage" class="form-control" type="text"name="leverage">
                    <br>
                    <br>

                    <input placeholder="enter the repurchase percentage" type="number" name="rep_rate" id="rep_rate" class="form-control">
                    <br>
                    <br>
                    <div class="row">
                        <div class="col-md-6">
                            <select class="col-sm-6 form-control" name="symbol">
                                <option selected disabled name="" id="">select a currency pair</option>
                                @foreach ($currpair as $item)
                                    <option value="{{ $item->name }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <select class="col-sm-6 form-control" name="side">
                                <option selected disabled value="">Select the side</option>
                                    <option value="Buy">Buy</option>
                                    <option value="Sell">Sell</option>
                            </select>
                        </div>
                    </div>

                    <br>
                    <br>
                    
                    <input placeholder="Enter the order price" class="form-control" type="text" name="price">
                    <br>
                    <br>
                    <input placeholder="Enter the quantity" class="form-control" type="text" name="qty">
                    <br>
                    <br>
                    
                    <input class="btn btn-success" type="submit" value="Save record">
                </form>
            </div>
        </div>

    </div>
</div>

@endsection