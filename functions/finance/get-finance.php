<?php
    include 'db-classes/banco.php';
    $users = new Users();

    if(!empty($data)){
        if (empty($data['user_id'])) 
            exit(json_encode("Id do usuario não pode ser vazio!"));

        $user_id = $data['user_id'];
        $response = $users->GetFinanceUsers($user_id);
        echo json_encode($response);

    } else {
    echo json_encode("Por favor contate um adminstrador!");
    }
?>