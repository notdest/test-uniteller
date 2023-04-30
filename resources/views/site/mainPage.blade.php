@extends('layouts.main')

@section('content')
<H1>Главная страница</H1>

<a href="/history">История операций</a>

@include('site.mainPageTable')

@endsection
