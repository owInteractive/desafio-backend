<?php
   if (!empty($data)){

      if (empty($data['id'])) 
         exit(json_encode("Por favor contate um adminstrador!"));

      if (empty($data['user_name'])) 
         exit(json_encode("Por favor insira um nome valido!"));

      if (empty($data['user_email']) && filter_var($data['user_email'], FILTER_VALIDATE_EMAIL)) 
         exit(json_encode("Por favor insira um email valido!"));

      if (empty($data['user_birthday'])) 
         exit(json_encode("Por favor insira um nome valido!"));

      include 'db-classes/banco.php';
      $contato = new Users();

      $id = $data['id'];
      $user_name =  $data['user_name'];
      $user_email = $data['user_email'];
      $user_birthday = $data['user_birthday'];
      $updated_at = date('d-m-Y');

      $response = $contato->EditUser($id, $user_name, $user_email, $user_birthday, $updated_at);
      echo json_encode($response);
   } else {
      echo json_encode("Por favor contate um adminstrador!");
   }
?>