<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Transaction;

class TransactionController extends Controller
{
    private function getAuthorization(Request $request)
    {
        $result = json_encode(array('error' => 'API token not provided.'));

        $headers = explode(PHP_EOL, $request);

        $token = null;
        foreach ($headers as $line) {
            if (substr($line, 0, 14) == "Authorization:") {
                $token = trim(substr($line, 15));

                if (substr($token, 0, 6) == "Bearer") {
                    $token = trim(substr($token, 7));
                }
            }
        }

        if ($token !== null) {
            $user = User::where('api_token', $token)->first();

            if (isset($user->api_token) && ($token == $user->api_token)) {
                $result = json_encode(array('success' => $token));
            } else {
                $result = json_encode(array('error' => 'API token not found.'));
            }
        } else {
            $result = json_encode(array('error' => 'API token not provided.'));
        }

        return $result;
    }

    public function listInformation($id, $page_number, $quantity_by_page)
    {
        // O usuário está usando o método correto?
        if (strtolower(request()->method()) != 'post') {
            return response()->json([
                'request_method_error' => 'Not allowed. This endpoint should be accessed through POST method.'
            ]);
        }

        // O usuário enviou o token de autorização junto com o cabeçalho?
        $result = $this->getAuthorization(request());

        $result_decode = json_decode($result, true);

        if (isset($result_decode['success'])) {
            $token = $result_decode['success'];
        } else {
            foreach ($result_decode as $k => $v) {
                return response()->json([
                    'error' => $result_decode[$k]
                ]);
            }
        }

        // O número do índice é maior do que 0?
        if ($page_number < 1) {
            return response()->json([
                'error' => 'The index is out of bounds. Page index starts at 1.'
            ]);
        }

        // A quantidade de resultados por página é menor do que 100?
        $result_array = array();
        if ($quantity_by_page > 100) {
            $quantity_by_page = 100;

            $temp_array = array (
                'quantity_by_page' => 'Quantity out of bounds, it must be between 1 and 100. Capped at 100.',
            );
            $result_array = $temp_array;
        }

        $users = DB::table('users')
            ->select('id', 'name', 'email', 'birthday', 'initial_balance', 'current_balance', 'created_at', 'updated_at')
            ->where('id', $id)
            ->get();

        $users_array = array();
        foreach($users as $user) {
            $result_array = array(
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'birthday' => $user->birthday,
                'initial_balance' => $user->initial_balance,
                'current_balance' => $user->initial_balance
            );
        }

        $transactions = DB::table('transactions')
            ->select('id', 'transaction_type', 'currency', 'amount', 'created_at')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'asc')
            ->offset(($page_number - 1) * $quantity_by_page)
            ->limit($quantity_by_page)
            ->get();

        if (count($transactions) > 0) {
            $result_array['transactions'] = $transactions;
        } else {
            $result_array['transactions'] = 'No transaction available.';
        }

        return response()->json([
            'user' => $result_array
        ]);
    }

    public function addCharge($id)
    {
        // O usuário está usando o método correto?
        if (strtolower(request()->method()) != 'post') {
            return response()->json([
                'request_method_error' => 'Not allowed. This endpoint should be accessed through POST method.'
            ]);
        }

        // O usuário enviou o token de autorização junto com o cabeçalho?
        $result = $this->getAuthorization(request());

        $result_decode = json_decode($result, true);

        if (isset($result_decode['success'])) {
            $token = $result_decode['success'];
        } else {
            foreach ($result_decode as $k => $v) {
                return response()->json([
                    'error' => $result_decode[$k]
                ]);
            }
        }

        // O índice informado corresponde a um usuário cadastrado?
        $user = User::find($id);
        if ($user === null) {
            return response()->json([
                'error' => 'No user found with the index provided.'
            ]);
        }

        $validator = Validator::make(request()->all(), [
            'transaction' => 'required|string',
            'currency' => 'required|string|size:3',
            'amount' => 'required|numeric|between:0,99999.99'
        ]);

        // Tipos permitidos de transação.
        $transactions_allowed = array(
            'balance',
            'credit',
            'debit',
            'reversal'
        );

        // O tipo de transação informado está entre os permitidos?
        if (!in_array(strtolower(request()->transaction), $transactions_allowed)) {
            return response()->json([
                'error' => 'Transaction types allowed are "balance," "credit," "debit," and "reversal".'
            ]);
        }

        // Moedas permitidas.
        $currencies_allowed = array(
            'BRL',
            'EUR',
            'GBP',
            'USD'
        );

        // Tabela de conversão entre moedas.
        $exchange_rate = array(
            1.00,
            6.52,
            7.53,
            5.43
        );

        // A moeda informada está entre as permitidas?
        if (!in_array(strtoupper(request()->currency), $currencies_allowed)) {
            return response()->json([
                'error' => 'Currencies allowed are "BRL," "EUR," "GBP," and "USD".'
            ]);
        }

        // Validação e conversão do montante informado.
        $total_amount = $user->current_balance;
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()[0]
            ]);
        } else {
            $amount = (float)0.00;
            if (isset(request()->amount)) {
                $amount = (float)request()->amount;
            }

            // O montante informado está dentro do limite permitido?
            if ($amount > 99999) {
                return response()->json([
                    'error' => 'Value out of bounds. Maximum allowed: 99999.'
                ]);
            }

            // Qual é a moeda informada?
            $currencies_key = array_search(request()->currency, $currencies_allowed);
            // Qual é o tipo de transação informado.
            $transaction_key = array_search(request()->transaction, $transactions_allowed);

            // A transação é o ajuste do valor do saldo?
            if ($transaction_key == 0) {
                $total_amount = ($amount * $exchange_rate[$currencies_key]);
            // A transação é estorno?
            } elseif ($transaction_key == 3) {
                $total_amount += ($amount * $exchange_rate[$currencies_key]);
            // A transação é crédito ou débito?
            } else {
                $total_amount -= ($amount * $exchange_rate[$currencies_key]);
            }

            $post_data = [
                'transaction' => strtolower(request()->transaction),
                'currency' => strtoupper(request()->currency),
                'amount' => $amount
            ];
        }

        // Armazenamento das informações.
        $transaction = Transaction::create([
            'user_id' => $user->id,
            'transaction_type' => $post_data['transaction'],
            'currency' => $post_data['currency'],
            'amount' => $post_data['amount']
        ]);

        // Atualização do saldo atual pós-conversão (caso necessário) da moeda.
        User::where('id', $user->id)
            ->update(['current_balance' => $total_amount]);

        if (isset($transaction->id)) {
            return response()->json([
                'error' => 'Transaction successful.'
            ]);
        } else {
            return response()->json([
                'error' => 'Transaction not successful.'
            ]);
        }
    }

    public function removeCharge($id)
    {
        // O usuário está usando o método correto?
        if (strtolower(request()->method()) != 'delete') {
            return response()->json([
                'request_method_error' => 'Not allowed. This endpoint should be accessed through POST method.'
            ]);
        }

        // O usuário enviou o token de autorização junto com o cabeçalho?
        $result = $this->getAuthorization(request());

        $result_decode = json_decode($result, true);

        if (isset($result_decode['success'])) {
            $token = $result_decode['success'];
        } else {
            foreach ($result_decode as $k => $v) {
                return response()->json([
                    'error' => $result_decode[$k]
                ]);
            }
        }

        // Tipos permitidos de transações.
        $transactions_type = array(
            'balance',
            'credit',
            'debit',
            'reversal'
        );

        // Moedas no formato ISO.
        $currencies_iso = array(
            'BRL',
            'EUR',
            'GBP',
            'USD'
        );

        // Tabela de conversão entre moedas.
        $exchange_rate = array(
            1.00,
            6.52,
            7.53,
            5.43
        );

        $transaction = Transaction::find($id);
        if ($transaction === null) {
            return response()->json([
                'error' => 'Transaction id provided not found.'
            ]);
        }

        $currencies_key = array_search($transaction->currency, $currencies_iso);
        $transaction_key = array_search($transaction->transaction_type, $transactions_type);

        $user = User::where('id', $transaction->user_id)->first();
        $current_balance = $user->current_balance;

        if ($transaction_key == 0) {
            //
        } elseif ($transaction_key == 3) {
            $current_balance -= ($transaction->amount * $exchange_rate[$currencies_key]);
        } else {
            $current_balance += ($transaction->amount * $exchange_rate[$currencies_key]);
        }

        // Atualiza o saldo atual do usuário.
        User::where('id', $user->id)
            ->update(['current_balance' => $current_balance]);

        if (($transaction !== null) && ($transaction->id == $id)) {
            $removed = $transaction->delete();

            if ($removed === true) {
                return response()->json([
                    'success' => 'Charge removed.'
                ]);
            } else {
                return response()->json([
                    'error' => 'Charge not removed.'
                ]);
            }
        } else {
            return response()->json([
                'error' => 'Charge not removed.'
            ]);
        }
    }

    public function chargesReport($id, $filter)
    {
        // O usuário está usando o método correto?
        if (strtolower(request()->method()) != 'post') {
            return response()->json([
                'request_method_error' => 'Not allowed. This endpoint should be accessed through POST method.'
            ]);
        }

        // O usuário enviou o token de autorização junto com o cabeçalho?
        $result = $this->getAuthorization(request());

        $result_decode = json_decode($result, true);

        if (isset($result_decode['success'])) {
            $token = $result_decode['success'];
        } else {
            foreach ($result_decode as $k => $v) {
                // return json_encode(array('error' => $result_decode[$k]));
                return response()->json([
                    'error' => $result_decode[$k]
                ]);
            }
        }

        /**
         * O filtro temporal está entre os permitidos?
         * 
         * Filtros permitidos:
         * - lastmonth: lista as transações dos últimos 30 dias;
         * - all: mostra todas as transações;
         * - MM-YY, mostra todas as transações de um determinado mês.
         */ 
        if ($filter == 'lastmonth') {
            $last_month = date("Y-m-d", strtotime('-1 Month'));

            $transactions = DB::table('transactions')
                ->select('id', 'transaction_type', 'currency', 'amount', 'created_at')
                ->where('user_id', $id)
                ->where('created_at', '>=', $last_month)
                ->orderBy('created_at', 'asc')
                ->get();
        } elseif ($filter == 'all') {
            $transactions = DB::table('transactions')
                ->select('id', 'transaction_type', 'currency', 'amount', 'created_at')
                ->where('user_id', $id)
                ->orderBy('created_at', 'asc')
                ->get();
        } else {
            if (strpos($filter, "-") === false) {
                return response()->json([
                    'error' => 'Date format invalid, it should be "MM-YY". "MM" stands for month and "YY" stands for year. Example: ' . date("m-y") . '.'
                ]);
            }

            $temp_date = explode("-", $filter);
            if ($temp_date[0] > 12) {
                return response()->json([
                    'error' => 'Date format invalid, it should be "MM-YY". "MM" stands for month and "YY" stands for year. Example: ' . date("m-y") . '.'
                ]);
            }

            if (($temp_date[1] >= '00') && ($temp_date[1] <= date("y"))) {
                $temp_date[1] = '20' . $temp_date[1];
            } else {
                $temp_date[1] = '19' . $temp_date[1];
            }
            $temp_date = '01-' . implode('-', $temp_date);
            $filter_date = array('date' => $temp_date);

            $validator = Validator::make($filter_date, [
                'date' => 'required|date'
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    'error' => $validator->errors()->all()[0]
                ]);
            }

            $start_date = $temp_date;
            $end_date = date("Y-m-d", strtotime('+1 Month', strtotime($start_date)));
            $end_date = date("Y-m-d", strtotime('-1 Day', strtotime($end_date)));
            $transactions = DB::table('transactions')
                ->select('id', 'transaction_type', 'currency', 'amount', 'created_at')
                ->where('user_id', $id)
                ->where('created_at', '>=', $start_date)
                ->where('created_at', '<=', $end_date)
                ->orderBy('created_at', 'asc')
                ->get();
        }

        // Cabeçalho com as informações do usuário.
        $user = User::find($id);
        $lines = "id,name,email,birthday,initial_balance,current_balance,\n";
        if ($user !== null) {
            $temp_line = $user->id . ',';
            $temp_line .= $user->name . ',';
            $temp_line .= $user->email . ',';
            $temp_line .= $user->birthday . ',';
            $temp_line .= $user->initial_balance . ",";
            $temp_line .= $user->current_balance . ",\n";

            $lines .= $temp_line;

            $result_decode = json_decode($transactions, true);

            if (count($transactions) > 0) {
                $lines .= "id,transaction_type,currency,amount,created_at,\n";
                foreach ($result_decode as $k => $v) {
                    $temp_line = $v['id'] . ',';
                    $temp_line .= $v['transaction_type'] . ',';
                    $temp_line .= $v['currency'] . ',';
                    $temp_line .= $v['amount'] . ',';
                    $temp_line .= $v['created_at'] . ",\n";
    
                    $lines .= $temp_line;
                }
            } else {
                $lines .= "No transactions found for the index provided.,\n";
            }
    
            return $lines;
        } else {
            return response()->json([
                'error' => 'No user found with the index provided.'
            ]);
        }
    }

    public function editBalance($id)
    {
        // O usuário está usando o método correto?
        if (strtolower(request()->method()) != 'put') {
            return response()->json([
                'request_method_error' => 'Not allowed. This endpoint should be accessed through PUT method.'
            ]);
        }

        // O usuário enviou o token de autorização junto com o cabeçalho?
        $result = $this->getAuthorization(request());

        $result_decode = json_decode($result, true);

        if (isset($result_decode['success'])) {
            $token = $result_decode['success'];
        } else {
            foreach ($result_decode as $k => $v) {
                return response()->json([
                    'request_method_error' => $result_decode[$k]
                ]);
            }
        }

        // Moedas no formato ISO.
        $currencies_iso = array(
            'BRL',
            'EUR',
            'GBP',
            'USD'
        );

        // Tabela de conversão entre moedas.
        $exchange_rate = array(
            1.00,
            6.52,
            7.53,
            5.43
        );

        $currencies_key = array_search(request()->currency, $currencies_iso);

        // Conversão do valor informado.
        $current_balance = (request()->amount * $exchange_rate[$currencies_key]);

        // O índice informado pertence a um usuário cadastrado?
        $user = User::find($id);
        if ($user === null) {
            return response()->json([
                'error' => 'User not found.'
            ]);
        }
        $user->current_balance = $current_balance;

        $edited = $user->save();
        if ($edited === true) {
            return response()->json([
                'success' => 'Current balance edited.'
            ]);
        } else {
            return response()->json([
                'error' => 'Current balance not edited.'
            ]);
        }
    }

    public function sumTransactions($id)
    {
        // O usuário está usando o método correto?
        if (strtolower(request()->method()) != 'post') {
            return response()->json([
                'request_method_error' => 'Not allowed. This endpoint should be accessed through POST method.'
            ]);
        }

        // O usuário enviou o token de autorização junto com o cabeçalho?
        $result = $this->getAuthorization(request());

        $result_decode = json_decode($result, true);

        if (isset($result_decode['success'])) {
            $token = $result_decode['success'];
        } else {
            foreach ($result_decode as $k => $v) {
                return response()->json([
                    'error' => $result_decode[$k]
                ]);
            }
        }

        // O número do índice é maior do que 0?
        if ($id < 1) {
            return response()->json([
                'error' => 'The index is out of bounds.'
            ]);
        }

        // O índice informado pertence a um usuário cadastrado?
        $user = User::find($id);
        if ($user === null) {
            return response()->json([
                'error' => 'User not found.'
            ]);
        }

        $user = array(
            'id' => $user->id,
            'name' => $user->name,
            'initial_balance' => $user->initial_balance,
            'current_balance' => $user->current_balance,
        );

        $transactions = DB::table('transactions')
            ->select('id', 'transaction_type', 'currency', 'amount', 'created_at')
            ->where('user_id', $id)
            ->orderBy('created_at', 'asc')
            ->get();

        if (count($transactions) > 0) {
            $user['transactions'] = $transactions;
        } else {
            $user['transactions'] = "No transactions found for the index provided.";
        }

        return $user;
    }

    public function transactionSeeder($id, $quantity)
    {
        // O usuário está usando o método correto?
        if (strtolower(request()->method()) != 'post') {
            return response()->json([
                'request_method_error' => 'Not allowed. This endpoint should be accessed through POST method.'
            ]);
        }

        // O usuário enviou o token de autorização junto com o cabeçalho?
        $result = $this->getAuthorization(request());

        $result_decode = json_decode($result, true);

        if (isset($result_decode['success'])) {
            $token = $result_decode['success'];
        } else {
            foreach ($result_decode as $k => $v) {
                return response()->json([
                    'error' => $result_decode[$k]
                ]);
            }
        }

        // A quantidade é maior do que 0?
        if ($quantity < 1) {
            return response()->json([
                'error' => 'Quantity out of bounds, it must be between 1 and 25.'
            ]);
        }

        $user_id = null;
        $current_balance = null;
        $user = User::where('id', $id)->first();
        if (isset($user->id)) {
            $user_id = $user->id;
            $current_balance = $user->current_balance;
        } else {
            return response()->json([
                'error' => 'User id provided was not found.'
            ]);
        }

        // Tipos permitidos de transações.
        $transaction_type = array(
            'balance',
            'credit',
            'debit',
            'reversal'
        );

        // Moedas permitidas.
        $currency_iso = array(
            'BRL',
            'EUR',
            'GBP',
            'USD'
        );

        // Tabela de conversão entre moedas.
        $exchange_rate = array(
            1.00,
            6.52,
            7.53,
            5.43
        );

        // A quantidade é maior do que 25?
        $transactions = array();
        if ($quantity > 25) {
            $quantity = 25;

            $temp_array = array (
                'quantity' => 'Quantity out of bounds, it must be between 1 and 25. Capped at 25.',
            );
            $transactions = $temp_array;
        }

        $total_amount = 0.00;
        for ($i = 0; $i < $quantity; $i++) {
            $tt = rand(0, 3);
            $transaction = $transaction_type[$tt];

            $cr = rand(0, 3);
            $currency = $currency_iso[$cr];

            $amount = rand(0, 900) . '.' . rand(0, 99);

            if ($tt == 3) {
                $total_amount += ($amount * $exchange_rate[$cr]);
            } else {
                $total_amount -= ($amount * $exchange_rate[$cr]);
            }

            $id = DB::table('transactions')->insertGetId([
                'user_id' => $user_id,
                'transaction_type' => $transaction,
                'currency' => $currency,
                'amount' => $amount,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ]);

            if ($id) {
                $temp_array = array (
                    'id' => $id,
                    'transaction' => $transaction,
                    'currency' => $currency,
                    'amount' => $amount
                );
                $transactions[$id] = $temp_array;
            }
        }

        $current_balance = $current_balance - $total_amount;
        User::where('id', $user_id)
            ->update(['current_balance' => $total_amount]);

        return response()->json([
            'transactions' => $transactions
        ]);
    }
}
