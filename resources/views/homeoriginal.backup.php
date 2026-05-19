@extends('layouts/contentNavbarLayout')
{{--  @extends('app')  --}}
@section('content')
@auth
{{--  <p> <b>{{ Auth::user()->name }}</b></p>  --}}
<!--<a  style="float: right;"  class="btn btn-danger" href="{{ route('logout') }}" >Logout</a>-->
@endauth
@guest
<a class="btn btn-primary" href="{{ route('login') }}">Login</a>
<a class="btn btn-info" href="{{ route('register') }}">Register</a>
@endguest
@endsection
