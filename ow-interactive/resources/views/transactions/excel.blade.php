<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>USER</th>
        <th>TRANSACTION TYPE</th>
        <th>VALUE</th>
        <th>CREATED_AT</th>
    </tr>
    </thead>
    <tbody>
    @foreach($transactions as $transaction)
        <tr>
            <td>{{ $transaction->id }}</td>
            <td>{{ $transaction->user->name }}</td>
            <td>{{ $transaction->transactionType->name }}</td>
            <td>{{ $transaction->value }}</td>
            <td>{{ $transaction->created_at }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
