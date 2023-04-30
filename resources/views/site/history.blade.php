@extends('layouts.main')

@section('content')
<H1>История операций</H1>

<a href="{{ route('mainPage') }}">На главную</a>

<form method="get" class="mt-3">
    <input type="text" name="search" value="{{ $search }}" placeholder="Поиск по сообщению">
    <input type="hidden" name="sort" value="{{$sort}}">
</form>

<table class="table ">
<thead>
    <tr>
        <th>#</th>
        <th><a href="{{ route('history') }}?sort={{ ($sort=='asc') ? 'desc':'asc' }}&search={{$search}}">Время</a></th>
        <th>Id пользователя</th>
        <th>Объём</th>
        <th>Сообщение</th>
    </tr>
</thead>
<tbody>
@foreach($operations as $operation)
    <tr>
        <td>{{$operation->id}}</td>
        <td>{{$operation->created_at}}</td>
        <td>{{$operation->user_id}}</td>
        <td>{{$operation->amount}}</td>
        <td>{{$operation->message}}</td>
    </tr>
@endforeach
</tbody>
</table>
@endsection
