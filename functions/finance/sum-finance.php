<?php
    include 'db-classes/banco.php';
    $users = new Users();

    if(!empty($data)){
        if (empty($data['user_id'])) 
            exit(json_encode("Id do usuario não pode ser vazio!"));

        $user_id = $data['user_id'];
        $response = $users->SumFinance($user_id);

        $soma = 0;

        if($response != false){
            foreach ($response as $item){
                $soma = $soma + intval($item["operation_value"]) ;
            }
        } 

        $resposta = $users->GetUser($user_id);
        $soma = $soma + intval($resposta['initial_balance']);

        echo json_encode("A soma de todas as moviementações foi de: " . number_format($soma, 2, '.', ','));
    } else {
    echo json_encode("Por favor contate um adminstrador!");
    }
?>