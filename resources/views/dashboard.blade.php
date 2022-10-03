@extends('includes.app')

@section('content')

<div class="container">
    <div class="position-relative row justify-content-center">
        <a href="{{ route('home') }}" class="btn btn-success col-md-6">GO TO ADD RECORDS</a>
        <div class="position-absolute col-md-12 mt-5">
            <div>
                @livewire('dashboard')
            </div>
        </div>

    </div>
</div>

@endsection