<?php
class Users {

    private $pdo;

    public function __construct(){
        $this->pdo = new PDO("mysql:dbname=ow;host=localhost", "root", "");
    }

    // CLASSES USERS
    public function InsertUser($user_name, $user_email, $user_birthday, $created_at, $initial_balance){

        $sql = "INSERT INTO users (
                    user_name,
                    user_email,
                    user_birthday,
                    created_at,
                    initial_balance)
                VALUE (
                    :user_name,
                    :user_email,
                    :user_birthday,
                    :created_at,
                    :initial_balance)";

        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(':user_name', $user_name);
        $sql->bindValue(':user_email', $user_email);
        $sql->bindValue(':user_birthday', $user_birthday);
        $sql->bindValue(':created_at', $created_at);
        $sql->bindValue(':initial_balance', $initial_balance);
        $sql->execute();
        return "usuario inserido";

    }

    public function GetUser($id){
        $sql= "SELECT * FROM users WHERE id = :id";
        $sql= $this->pdo->prepare($sql);
        $sql->bindValue(':id', $id);
        $sql->execute();

        if($sql->rowCount() > 0){
            return $sql->fetch(PDO::FETCH_ASSOC);
        }else{
            return "Não encontramos nenhuma usuario com esse id.";
        }
    }

    public function GetAllUsers(){
        $sql = "SELECT * FROM users ORDER BY created_at ASC";

        $sql = $this->pdo->query($sql);

		if($sql->rowCount() > 0) {
			return $sql->fetchAll(PDO::FETCH_ASSOC);
		} else {
			return "Não encontramos nenhuma usuario cadastro.";
		}
    }

    public function EditUser($id, $user_name, $user_email, $user_birthday, $updated_at){
        $sql = "UPDATE users SET
            user_name = :user_name,
            user_email = :user_email,
            user_birthday = :user_birthday,
            updated_at = :updated_at

        WHERE id = :id";

        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(':id', $id);
        $sql->bindValue(':user_name', $user_name);
        $sql->bindValue(':user_email', $user_email);
        $sql->bindValue(':user_birthday', $user_birthday);
        $sql->bindValue(':updated_at', $updated_at);
        $sql->execute();
        return "Usuario editado com sucesso!";
	}

    public function DeleteUser($id){
        $sql = "DELETE FROM users WHERE id = :id";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(':id', $id);
        $sql->execute();

        return "Usuario apagado com sucesso!";
    }


    public function UpadateBalance($id, $initial_balance){
        $sql = "UPDATE users SET initial_balance = :initial_balance

        WHERE id = :id";

        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(':id', $id);
        $sql->bindValue(':initial_balance', $initial_balance);
        $sql->execute();
        return "Saldo inicial editado com sucesso";
	}


    // FINANCE CLASSES
    public function InsertFinance($user_id, $operation_name, $operation_value){

        $sql = "INSERT INTO financial (
                    user_id,
                    operation_name,
                    operation_value)
                VALUE (
                    :user_id,
                    :operation_name,
                    :operation_value)";

        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(':user_id', $user_id);
        $sql->bindValue(':operation_name', $operation_name);
        $sql->bindValue(':operation_value', $operation_value);
        $sql->execute();

        return "Operação Inserida com sucesso!";
    }

    public function GetFinance($user_id){

        $sql= "SELECT * FROM financial WHERE user_id = :id";
        $sql= $this->pdo->prepare($sql);
        $sql->bindValue(':id', $user_id);
        $sql->execute();

        if($sql->rowCount() > 0){
            return $sql->fetchAll(PDO::FETCH_ASSOC);
        }else{
            return false;
        }
    }

    public function GetFinanceUsers($user_id){
        $arrayUsers = $this->GetUser($user_id);

        $arrayFinance = $this->GetFinance($user_id);
        if($arrayFinance != false){
            return ['user' => $arrayUsers, "Finance" => $arrayFinance];
        }else{
            return "Não foi possivel encotrar as operações relacionas a esse usuario";
        }
    }

    public function DeleteFinance($id){
        $sql = "DELETE FROM financial WHERE id = :id";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(':id', $id);
        $sql->execute();

        return "Movimentação apagado com sucesso!";
    }


    // OTHER CLASSES

    public function CreatCsv($user_id){
        $arrayFinance = $this->GetFinance($user_id);

        if($arrayFinance != false){
            $file = fopen("finance.csv", "w");

            foreach ($arrayFinance as $linha) {
                fputcsv($file, $linha, ";");
            }

        }else{
            return "Não foi possivel encotrar as operações relacionas a esse usuario";
        }
    }

    public function SumFinance($user_id){
        $sql = $this->GetFinance($user_id);

        if($sql != false){
            $arrayFinance = $sql->fetchAll(PDO::FETCH_ASSOC);
            return $arrayFinance;
        }else{
            return false;
        }
    }
    
    public function HaveFinance($user_id){
        $sql = $this->GetFinance($user_id);

        if($sql == false){
            return true;
        }else{
            return false;
        }
    }
}