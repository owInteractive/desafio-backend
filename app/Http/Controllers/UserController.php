<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Transaction;

class UserController extends Controller
{
    public function register(Request $request)
    {
        // O usuário está usando o método correto?
        if (strtolower(request()->method()) != 'post') {
            return response()->json([
                'request_method_error' => 'Not allowed. This endpoint should be accessed through POST method.'
            ]);
        }

        // Verificação do preenchimento das informações.
        $filled = 0;
        if (isset(request()->name) && !empty(request()->name)) {
            $filled += 1;
        }
        if (isset(request()->email) && !empty(request()->email)) {
            $filled += 1;
        }
        if (isset(request()->birthday) && !empty(request()->birthday)) {
            $filled += 1;
        }
        if (isset(request()->password) && !empty(request()->password)) {
            $filled += 1;
        }
        if (isset(request()->initial_balance) && !empty(request()->initial_balance)) {
            $filled += 1;
        }

        if ($filled == 0) {
            return response()->json([
                'error' => 'No information was provided.'
            ]);
        } elseif ($filled < 5) {
            return response()->json([
                'error' => 'All fields must be filled.'
            ]);
        }

        // Formatação de algumas das informações que devem ser recebidas.
        $birthday = date("Y-m-d", strtotime(request()->birthday));
        $initial_balance = (float)0.00;
        if (isset(request()->initial_balance)) {
            $initial_balance = (float)request()->initial_balance;
        }

        if ($initial_balance > 99999) {
            return response()->json([
                'error' => 'Value out of bounds. Maximum allowed: 99999.'
            ]);
        }

        // Envio das informações para que o controlador de autenticação faça o registro do novo usuário.
        $response = Http::post(route('apiregister'), [
            'name' => request()->name,
            'email' => request()->email,
            'birthday' => $birthday,
            'password' => Hash::make(request()->password),
            'initial_balance' => $initial_balance
        ]);

        /**
         * Se o registro foi bem sucedido, a resposta é constituída por três partes:
         * - "success";
         * - "api_token", que será usado para qualquer operação futura que o usuário deseje fazer;
         * - "token_type", do tipo "Bearer".
         */
        $response_array = json_decode($response, true);
        if (isset($response_array['api_token']) && isset($response_array['token_type'])) {
            return response()->json([
                'success' => 'User registered.',
                'api_token' => $response_array['api_token'],
                'token_type' => $response_array['token_type']
            ]);
        } else {
            return response()->json([
                'error' => 'User not registered.'
            ]);
        }
    }

    private function getAuthorization(Request $request)
    {
        // O token de autorização não foi incluído no cabeçalho.
        $result = json_encode(array('error' => 'API token not provided.'));

        $headers = explode(PHP_EOL, $request);

        // Procura o token no cabeçalho.
        $token = null;
        foreach ($headers as $line) {
            if (substr($line, 0, 14) == "Authorization:") {
                $token = trim(substr($line, 15));

                if (substr($token, 0, 6) == "Bearer") {
                    $token = trim(substr($token, 7));
                }
            }
        }

        // O token foi encontrado?
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

    public function listAll($page_number, $quantity_by_page)
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

        // O número da página é maior do que 0?
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
            ->select('id', 'name', 'email', 'birthday', 'initial_balance', 'created_at', 'updated_at')
            ->orderBy('created_at', 'asc')
            ->offset(($page_number - 1) * $quantity_by_page)
            ->limit($quantity_by_page)
            ->get();

        $users_array = array();
        foreach($users as $user) {
            $temp_array = array (
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'birthday' => $user->birthday,
                'initial_balance' => $user->initial_balance,
                'current_balance' => $user->initial_balance
            );
            $users_array[$user->id] = $temp_array;
        }
        $result_array['users'] = $users_array;

        return $result_array;
    }

    public function listOne($id)
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

        $user = DB::table('users')
            ->select('id', 'name', 'email', 'birthday', 'initial_balance', 'created_at', 'updated_at')
            ->where('id', $id)
            ->get();

        if (count($user) == 1) {
            return response()->json([
                'user' => $user
            ]);
        } else {
            $user_array = array();
            foreach($user as $u) {
                $temp_array = array (
                    'id' => $u->id,
                    'name' => $u->name,
                    'email' => $u->email,
                    'birthday' => $u->birthday,
                    'created_at' => $u->created_at,
                    'updated_at' => $u->updated_at
                );
                $user_array['user'] = $temp_array;
            }

            return response()->json([
                'user' => 'No user found with the index provided.'
            ]);
        }
    }

    public function addOne(Request $request)
    {
        // O usuário está usando o método correto?
        if (strtolower(request()->method()) != 'post') {
            return response()->json([
                'request_method_error' => 'Not allowed. This endpoint should be accessed through POST method.'
            ]);
        }

        // O usuário enviou o token de autorização junto com o cabeçalho?
        $result = $this->getAuthorization($request);

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

        // O valor do saldo inicial está dentro dos limites?
        if ($request->initial_balance > 99999) {
            return response()->json([
                'error' => 'Value out of bounds. Maximum allowed: 99999.'
            ]);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'birthday' => 'required|date',
            'password' => 'required|min:8',
            'initial_balance' => 'required|numeric|between:0,99999.99'
        ]);

        // As informações puderam ser validadas?
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()[0]
            ]);
        } else {
            $birthday_timestamp = strtotime($request->birthday);
            $legal_age_timestamp = strtotime('-18 Years');
            $time_diff = $birthday_timestamp - $legal_age_timestamp;
            if ($time_diff > 0) {
                return response()->json([
                    'error' => 'User needs to be at least 18 years old.'
                ]);
            }

            $birthday = date("Y-m-d", strtotime($request->birthday));
            $initial_balance = (float)0.00;
            if (isset($request->initial_balance)) {
                $initial_balance = (float)$request->initial_balance;
            }

            $post_data = [
                'name' => $request->name,
                'email' => $request->email,
                'birthday' => $birthday,
                'password' => $request->password,
                'initial_balance' => $initial_balance,
                'current_balance' => $initial_balance
            ]; 
        }

        // Envio das informações para que o controlador de autenticação faça o registro do novo usuário.
        $user = User::create([
            'name' => $post_data['name'],
            'email' => $post_data['email'],
            'birthday' => $post_data['birthday'],
            'password' => Hash::make($post_data['password']),
            'initial_balance' => $post_data['initial_balance'],
            'current_balance' => $post_data['initial_balance']
        ]);

        $token = $user->createToken('authToken')->plainTextToken;

        User::where('email', $post_data['email'])
            ->update(['api_token' => $token]);

        return response()->json([
            'success' => 'User registered.',
            'api_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function removeOne($id)
    {
        // O usuário está usando o método correto?
        if (strtolower(request()->method()) != 'delete') {
            return response()->json([
                'request_method_error' => 'Not allowed. This endpoint should be accessed through DELETE method.'
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

        $user = User::find($id);
        if (($user !== null) && ($user->id == $id)) {
            $transactions = Transaction::where('user_id', $user->id)->first();
            if (isset($transactions->id) && ($transactions->id !== null)) {
                return response()->json([
                    'error' => 'User can\'t be removed, he/she has transactions stored.'
                ]);
            }

            $removed = $user->delete();

            if ($removed === true) {
                return response()->json([
                    'success' => 'User removed.'
                ]);
            } else {
                return response()->json([
                    'error' => 'User not removed.'
                ]);
            }
        } else {
            return response()->json([
                'error' => 'User not removed.'
            ]);
        }
    }

    public function editOne($id)
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
                    'error' => $result_decode[$k]
                ]);
            }
        }

        // O número da página é maior do que 0?
        if ($id < 1) {
            return response()->json([
                'error' => 'The index is out of bounds.'
            ]);
        }

        // Validação do nome do usuário.
        $name = null;
        if (isset(request()->name) && (request()->name !== null)) {
            $name = request()->name;

            $validator_array = array('name' => $name);
            $validator = Validator::make($validator_array, [
                'name' => 'required|string'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => $validator->errors()->all()[0]
                ]);
            }
        }

        // Validação do email do usuário.
        $email = null;
        if (isset(request()->email) && (request()->email !== null)) {
            $email = request()->email;

            $validator_array = array('email' => $email);
            $validator = Validator::make($validator_array, [
                'email' => 'required|string|email'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => $validator->errors()->all()[0]
                ]);
            }

            $user = DB::table('users')
                ->select('id', 'email')
                ->where('email', $email)
                ->get();

            foreach($user as $u) {
                if ($u->id != $id) {
                    return response()->json([
                        'error' => 'Email already in use.'
                    ]);
                }
            }
        }

        // Validação da data de nascimento do usuário.
        $birthday = null;
        if (isset(request()->birthday) && (request()->birthday !== null)) {
            $birthday_timestamp = strtotime(request()->birthday);
            $legal_age_timestamp = strtotime('-18 Years');
            $time_diff = $birthday_timestamp - $legal_age_timestamp;
            if ($time_diff > 0) {
                return response()->json([
                    'error' => 'User needs to be at least 18 years old.'
                ]);
            }
    
            $birthday = date("Y-m-d", strtotime(request()->birthday));

            $validator_array = array('birthday' => $birthday);
            $validator = Validator::make($validator_array, [
                'birthday' => 'required|date'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => $validator->errors()->all()[0]
                ]);
            }
        }

        // Validação da senha do usuário.
        $password = null;
        if (isset(request()->password) && (request()->password !== null)) {
            $password = Hash::make(request()->password);

            $validator_array = array('password' => $password);
            $validator = Validator::make($validator_array, [
                'password' => 'required|min:8'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => $validator->errors()->all()[0]
                ]);
            }
        }

        // Validação do saldo inicial do usuário.
        $initial_balance = null;
        if (isset(request()->initial_balance) && (request()->initial_balance !== null)) {
            $initial_balance = (float)request()->initial_balance;

            $validator_array = array('initial_balance' => $initial_balance);
            $validator = Validator::make($validator_array, [
                'initial_balance' => 'required|numeric|between:0,99999.99'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => $validator->errors()->all()[0]
                ]);
            }

            if ($initial_balance > 99999) {
                return response()->json([
                    'error' => 'Value out of bounds. Maximum allowed: 99999.'
                ]);
            }
        }

        // O índice fornecido corresponde a um usuário real?
        $user = User::find($id);
        if (($user !== null) && ($user->id == $id)) {
            $confirmation = 0;
            if ($name !== null) {
                $user->name = $name;
                $confirmation += 1;
            }

            if ($email !== null) {
                $user->email = $email;
                $confirmation += 1;
            }

            if ($birthday !== null) {
                $user->birthday = $birthday;
                $confirmation += 1;
            }

            if ($password !== null) {
                $user->password = $password;
                $confirmation += 1;
            }

            if ($initial_balance !== null) {
                $user->initial_balance = $initial_balance;
                $confirmation += 1;
            }

            $edited = false;
            if ($confirmation > 0) {
                $edited = $user->save();

                if ($edited === true) {
                    return response()->json([
                        'success' => 'User edited.'
                    ]);
                } else {
                    return response()->json([
                        'error' => 'User not edited.'
                    ]);
                }
            } else {
                return response()->json([
                    'error' => 'No content was provided. User not edited.'
                ]);
            }
        } else {
            return response()->json([
                'error' => 'User not edited.'
            ]);
        }
    }

    public function userSeeder($quantity)
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

        $first_names = array(
            'Anderson',
            'Karen',
            'Evandro',
            'Roberta',
            'Luiz',
            'Silvia'
        );

        $last_names = array(
            'Silva',
            'Azevedo',
            'Pereira',
            'Cabral',
            'Macedo',
            'Fiorin'
        );

        $email_providers = array(
            '@gmail.com',
            '@hotmail.com',
            '@bol.com.br',
            '@protonmail.com',
            '@etminhacasa.terra',
            '@bb.com'
        );

        // A quantidade é maior do que 25?
        $users = array();
        if ($quantity > 25) {
            $quantity = 25;

            $temp_array = array (
                'quantity' => 'Quantity out of bounds, it must be between 1 and 25. Capped at 25.',
            );
            $users = $temp_array;
        }

        for ($i = 0; $i < $quantity; $i++) {
            $r = rand(0, 5);
            $name = $first_names[$r] . ' ';
            $email = strtolower($first_names[$r]);

            $r = rand(0, 5);
            $name .= $last_names[$r];
            $email .= strtolower($last_names[$r]) . rand(1, 1000);

            $r = rand(0, 5);
            $email .= $email_providers[$r];

            $year = rand(1900, 2002);
            $month = rand(1, 12);
            if ($month < 10) {
                $month = str_pad($month, 2, "0", STR_PAD_LEFT);
            }
            $day = rand(1, 28);
            if ($day < 10) {
                $day = str_pad($day, 2, "0", STR_PAD_LEFT);
            }
            $birthday = "$year-$month-$day";

            $initial_balance = rand(0, 99999) . '.' . rand(0, 99);
            $initial_balance = number_format($initial_balance, 2, ".", "");

            $id = DB::table('users')->insertGetId([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make('123123123'),
                'birthday' => $birthday,
                'api_token' => str_shuffle($token),
                'initial_balance' => $initial_balance,
                'current_balance' => $initial_balance,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ]);

            if ($id) {
                $temp_array = array (
                    'id' => $id,
                    'name' => $name,
                    'email' => $email,
                    'birthday' => $birthday,
                    'initial_balance' => $initial_balance,
                    'current_balance' => $initial_balance
                );
                $users[$id] = $temp_array;
            }
        }

        return response()->json([
            'users' => $users
        ]);
    }

    public function Start()
    {
        if (strtolower(request()->method()) != 'get') {
            return response()->json([
                'request_method_error' => 'Not allowed. This endpoint should be accessed through GET method.'
            ]);
        }

        return response()->json([
            'error' => 'The server found and error and could not recover. Please use one of the following routes to continue:',
            '.---------' => '----------',
            'USERS' => '-',
            '/register (POST)' => 'Registers a new user. Returns the new user\'s API key,',
            '/adduser (POST)' => 'Adds a new user. Returns the new user\'s API key,',
            '/listusers/{page_number}/{quantity_by_page} (POST)' => 'Lists information of all users,',
            '/listuser/{id} (POST)' => 'Lists information of only one user,',
            '/edituser/{id} (PUT)' => 'Edits the information of a user,',
            '/removeuser/{id} (DELETE)' => 'Deletes a user,',
            '/userseeder/{quantity} (POST)' => 'Seeds new users,',
            '..--------' => '----------',
            'TRANSACTIONS' => '-',
            '/addcharge/{id} (POST)' => 'Adds charges to the user\'s balance,',
            '/listinformation/{id}/{page_number}/{quantity_by_page} (POST)' => 'Lists information of a user\'s balance,',
            '/chargesreport/{id}/{filter} (POST)' => 'Lists information of a user\'s balance in a period of time,',
            '/sumtransactions/{id} (POST)' => 'Lists user\'s transactions, and initial and current balance,',
            '/editbalance/{id} (PUT)' => 'Edits user\'s initial balance,',
            '/removecharge/{id} (DELETE)' => 'Deletes a charge from a user\'s balance,',
            '/transactionseeder/{id}/{quantity} (POST)' => 'Seeds charges to a user\'s balance.',
        ]);
    }
}
