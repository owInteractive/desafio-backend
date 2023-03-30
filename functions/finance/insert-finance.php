<?php
    if(!empty($data)){

        if (empty($data['operation_type'])) 
            exit(json_encode("Por favor insira um nome valido!"));
        
        if (empty($data['operation_value']) && filter_var($data['user_email'], FILTER_VALIDATE_EMAIL)) 
            exit(json_encode("Por favor insira um email valido!"));
        
        if (empty($data['user_id'])) 
            exit(json_encode("Por favor insira um nome valido!"));

        include 'db-classes/banco.php';
        $contato = new Users();

        $user_id = $data['user_id'];
        $operation_value = $data['operation_value'];
        $finance_create_at = date('d-m-Y');

        switch ($data['operation_type']) {
            case '1':
                $operation_name = "Debito";
                break;
            case '2':
                $operation_name = "Credito";
                break;
            case '3':
                $operation_name = "Extorno";
                break;
            default:
                exit(json_encode("Por favor digite um numero para a operação valido"));
                break;
        }

        $response = $contato->InsertFinance($user_id, $operation_name, $operation_value);
        echo json_encode($response);
    } else {
        echo json_encode("Por favor contate um adminstrador!");
    }
?>