@extends('layouts.app')

@section('content')
    <div id="loader">
        <i class="fa fa-spinner fa-spin"></i>
        Loading...
    </div>

    @include('components.panel')
@endsection