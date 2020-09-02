<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Cliente</th>
        <th>Tipo da Transação</th>
        <th>Valor</th>
        <th>Data</th>
    </tr>
    </thead>
    <tbody>
    @foreach($transactions as $transaction)
        <tr>
            <td>{{ $transaction->id }}</td>
            <td>{{ $transaction->user->name }}</td>
            <td>{{ $transaction->type->title }}</td>
            <td>{{ $transaction->value }}</td>
            <td>{{ \Carbon\Carbon::parse($transaction->created_at)->format('d/m/Y H:i:s') }}</td>
        </tr>
    @endforeach
    </tbody>
</table>