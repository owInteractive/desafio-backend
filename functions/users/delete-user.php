<?php
    include 'db-classes/banco.php';
    $user = new Users();

    if (empty($data['id'])) 
        exit(json_encode("Por favor contate um adminstrador!"));

    $id = $data['id'];
    $response = $user->HaveFinance($id);
    if($response == true)
        exit(json_encode("Não pode alterar usuario que tenha operações!"));

    $respone = $user->GetUser($id);
    if($respone["initial_balance"] != "0")
        exit(json_encode("Não pode alterar usuario que tenha saldo!"));
    
    
    $response = $user->DeleteUser($id);

    echo json_encode($response);

?>