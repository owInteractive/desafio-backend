<?php
    include 'db-classes/banco.php';
    $user = new Users();

    if(!empty($data)){
        if (empty($data['finance_id'])) 
            exit(json_encode("Por favor contate um adminstrador!"));

        $id = $data['finance_id'];
        $response = $user->DeleteFinance($id);
        echo json_encode($response);

    } else {
    echo json_encode("Por favor contate um adminstrador!");
    }
?>