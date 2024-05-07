<?php
// Database credentials
$dsn = 'mysql:host=localhost;dbname=ishyura;charset=utf8';
$username = 'root'; // Change this to your database username
$password = ''; // Change this to your database password

try {
    // Establish the database connection
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Connection successful, you can now use $pdo to interact with the database
    // echo "Connected successfully!";
} catch (PDOException $e) {
    // Connection failed, display error message
    // echo 'Connection failed: ' . $e->getMessage();
}


  

    // Receive data from the gateway
    $phoneNumber = $_POST['from'];
    $text = $_POST['text']; // Format: "name id email pin"
    $text = explode(" ", $text);

    if (count($text) >= 3) {
        $name = $text[0];
        $regno = $text[1];
        $pin = $text[2];

        // Check if any of the fields are empty
        if (empty($name)) {
            echo "END Fill your name";
        } else if (empty($regno)) {
            echo "END Enter your Registration Number";       
        } else if (empty($pin)) {
            echo "END Enter your PIN number";
        } else {
            // Check if phone number already exists
            $stmt_check =  $pdo->prepare("SELECT * FROM users WHERE phoneNumber = :telephone");
            $stmt_check->bindValue(':telephone', $phoneNumber);
            $stmt_check->execute();
            $existingUser = $stmt_check->fetch(PDO::FETCH_ASSOC);

            if ($existingUser) {
                echo "END Phone number $phoneNumber already registered";
            } else {
                // Insert new member if not already registered
                $stmt =  $pdo->prepare("INSERT INTO `users`( `names`, `regno`, `phoneNumber`, `pin`) 
                VALUES (:names, :regno, :phoneNumber, :pin)");
                $stmt->bindValue(':names', $name);
                $stmt->bindValue(':regno', $regno);
                $stmt->bindValue(':phoneNumber', $phoneNumber);                
                $stmt->bindValue(':pin', $pin);

                if ($stmt->execute()) {
                    echo "you heve successfull registerd the following information: \n name is:  $name\n your RegNo is:  $regno \n your phone number is : $phoneNumber \n";
                } else {
                    echo "Failed to insert";
                }
            }
        }
    } else {
        // Check which field is empty and prompt for it
        $missingFields = [];
        if (empty($text[0])) {
            $missingFields[] = "name";
        }
        if (empty($text[1])) {
            $missingFields[] = "regno";
        }
        if (empty($text[2])) {
            $missingFields[] = "pin";
        }
       

        if (count($missingFields) > 0) {
            $message = "END Fill your ";
            $message .= implode(", ", $missingFields);
            echo $message;
        } else {
            // If all fields are provided but count is less than 4
            echo "END Please provide all required information";
        }
        
    
}
?>
