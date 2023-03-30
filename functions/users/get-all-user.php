<?php
    include 'db-classes/banco.php';
    $users = new Users();
    
    $response = $users->GetAllUsers();
    echo json_encode($response);
    ?>