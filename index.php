<?php
    //remote URL CALLBACK: https://d936-41-186-78-2.ngrok-free.app/ussdsms/index.php

    //local: http://localhost:80/ussdsms/index.php
    include_once 'menu.php';
    $sessionId = $_POST['sessionId'];
    $phoneNumber = $_POST['phoneNumber'];
    $serviceCode = $_POST['serviceCode'];
    $text = $_POST['text'];

    // Database connection and query to check if the phone number exists in the users table
    $dsn = 'mysql:host=localhost;dbname=ishyura;charset=utf8';
    $username = 'root'; // Change this to your database username
    $password = ''; // Change this to your database password

    try {
        $pdo = new PDO($dsn, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Check if the phone number exists in the users table
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE phoneNumber = :phone");
        $stmt->bindParam(':phone', $phoneNumber);
        $stmt->execute();
        $isRegistered = $stmt->fetchColumn() > 0;
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
        exit;
    }

    //$menu = new Menu($text, $sessionId);
    $menu = new Menu($text, $sessionId);
    $text = $menu->middleware($text);

    if($text == "" && !$isRegistered){
        //Do something
        $menu->mainMenuUnregistered();
    }
    else if($text == "" && $isRegistered){
        //Do something
        $menu->mainMenuRegistered();
    }
    else if(!$isRegistered){
        //Do something
        $textArray = explode("*", $text);
        switch($textArray[0]){
            case 1:
                $menu->menuRegister($textArray);
                break;
            default:
                echo "END Invalid option, retry";
        }
    }
    else{
        //Do something
        $textArray = explode("*", $text);
        switch($textArray[0]){
            case 1:
                $menu->menuSendMoney($textArray);
                break;
            case 2:
                $menu->menuPaidAmount($textArray);
                break;
            case 3:
                $menu->menuUnPaidAmount($textArray);
                break;
            default:
                echo "END Invalid choice\n";
        }
    }
?>
