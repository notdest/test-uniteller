<div class="mt-3">
    <b>Баланс:</b> {{$balance}}
</div>
<table class="table ">
    <thead>
    <tr>
        <th>#</th>
        <th>Время</th>
        <th>Объём</th>
        <th>Сообщение</th>
    </tr>
    </thead>
    <tbody>
    @foreach($operations as $operation)
    <tr>
        <td>{{$operation->id}}</td>
        <td>{{$operation->created_at}}</td>
        <td>{{$operation->amount}}</td>
        <td>{{$operation->message}}</td>
    </tr>
    @endforeach
    </tbody>
</table>
