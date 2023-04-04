<table class="table table-bordered table-striped dataTable dtr-inline">
    <thead>
    <tr>
        <th style="font-weight: bold; text-align: center; background-color: #ed969e">Fio</th>
        <th style="font-weight: bold; text-align: center; background-color: #ed969e">Card</th>
        <th style="font-weight: bold; text-align: center; background-color: #ed969e">Limit</th>
        <th style="font-weight: bold; text-align: center; background-color: #ed969e">Date expiry</th>
        <th style="font-weight: bold; text-align: center; background-color: #ed969e">Balance</th>
        <th style="font-weight: bold; text-align: center; background-color: #ed969e">Status</th>
    </tr>
    </thead>
    <tbody>
    @foreach($clients as $c)
        <tr>
            <td>
                {{ $c->first_name.' '.$c->middle_name.' '.$c->last_name }}
            </td>
            <td>{{ $c->card->number }}</td>
            <td>{{ $c->limit }}</td>
            <td>{{ $c->date_expiry }}</td>
            <td>{{ $c->card->balance }}</td>
            <td>{{ $c->status }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
