<?php
    include 'db-classes/banco.php';
    $users = new Users();

    if (empty($data['id'])) 
        exit(json_encode("Por favor informe o id de um usuario!"));

    $id = $data['id'];
    $response = $users->GetUser($id);
    echo json_encode($response);

?>