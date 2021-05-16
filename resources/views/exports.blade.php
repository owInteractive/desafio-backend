<table style="text-align:center;">
    <thead> 
    <tr>
        <th>Nome</th>
        <th>Email</th>
        <th>Data Nascimento</th>
        <th>Saldo Atual</th>
    </tr>
    </thead>
    <tbody>    
        <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->birthday }}</td>
            <td>R$ {{ $user->actual_balance($user->opening_balance)}}</td>
        </tr>
    </tbody>
</table> 

<table style="text-align:center;">
    <thead> 
    <tr>
        <th>Cód</th>
        <th>Tipo de Operação</th>
        <th>Valor</th>
        <th>Data</th>
    </tr>
    </thead>
    <tbody>
    @foreach($movements as $mov)
        <tr>
            <td>{{ $mov->id }}</td>
            <td>{{ $mov->operation }}</td>
            <td>R$ {{ $mov->valueformat }}</td>
            <td>{{ $mov->created_at }}</td>
        </tr>
    @endforeach
    </tbody>
</table>