<?php
    if(!empty($data)){

        if (empty($data['user_name'])) 
            exit(json_encode("Por favor insira um nome!"));
        
        if (empty($data['user_email']) && filter_var($data['user_email'], FILTER_VALIDATE_EMAIL)) 
            exit(json_encode("Por favor insira um email!"));
        
        if (empty($data['user_birthday'])) 
            exit(json_encode("Por favor insira a data de aniversario!"));
        

        $time_input = strtotime($data['user_birthday']); 
        $date_input = getDate($time_input); 
            
        if((date('Y') - $date_input["year"]) < 18) {
            exit(json_encode("Só pode criar conta se for maior de 18 anos"));
        }
        else if(date('Y') - $date_input["year"] == 18) {
            if($date_input["mon"] > date('M')){
                exit(json_encode("Só pode criar conta se for maior de 18 anos"));
            } 
            else if($date_input["mon"] == date('M')){
                if($date_input["day"] >= date('D')){
                    exit(json_encode("Só pode criar conta se for maior de 18 anos"));
                }
            }
        }

        include 'db-classes/banco.php';
        $contato = new Users();

        $user_name =  $data['user_name'];
        $user_email = $data['user_email'];
        $user_birthday = $data['user_birthday'];
        empty($data['initial_balance']) ? $initial_balance = 0 : $initial_balance = $data['initial_balance'];
        $created_at = date('d-m-Y');

        $response = $contato->InsertUser($user_name, $user_email, $user_birthday, $created_at, $initial_balance);
        echo json_encode($response);
    } else {
        echo json_encode("Por favor contate um adminstrador!");
    }
?>