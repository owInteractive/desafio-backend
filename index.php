<?php
//Cabecalhos obrigatorios
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: GET,PUT,POST,DELETE");


$action = $_GET['action'];
$data = json_decode(file_get_contents('php://input'), true);

switch ($action) {

            // Require Finance Files
    case 'get-all-user':
        require('functions/users/' . $action . '.php');
        break;
    case 'get-user':
        require('functions/users/' . $action . '.php');
        break;
    case 'insert-user':
        require('functions/users/' . $action . '.php');
        break;
    case 'update-user':
        require('functions/users/' . $action . '.php');
        break;
    case 'delete-user':
        require('functions/users/' . $action . '.php');
        break;

        // Require Finance Files
    case 'insert-finance':
        require('functions/finance/' . $action . '.php');
        break;
    case 'get-finance':
        require('functions/finance/' . $action . '.php');
        break;
    case 'delete-finance':
        require('functions/finance/' . $action . '.php');
        break;
    case 'create-csv':
        require('functions/finance/' . $action . '.php');
        break;

        // Other Requires
    case 'update-initial-balance':
        require('functions/' . $action . '.php');
        break;
    case 'sum-finance':
        require('functions/finance/' . $action . '.php');
        break;

    default:
        echo json_encode("Algo deu errado! Contate um administrador");
        break;
}

http_response_code(200);