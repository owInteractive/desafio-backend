<?php
   if (!empty($data)){

      if (empty($data['user_id'])) 
         exit(json_encode("Por favor contate um adminstrador!"));


      include 'db-classes/banco.php';
      $contato = new Users();

      $id = $data['user_id'];
      empty($data['initial_balance']) ? $initial_balance = 0 : $initial_balance = $data['initial_balance'];

      $response = $contato->UpadateBalance($id, $initial_balance);
      echo json_encode($response);
   } else {
      echo json_encode("Por favor contate um adminstrador!");
   }
?>