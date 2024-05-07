<?php
    include_once 'util.php';
    class Menu{
        protected $text;
        protected $sessionId;
        protected $pdo; // PDO object for database connection


        function __construct($text, $sessionId){
            $this->text = $text;
            $this->sessionId;
            $dsn = 'mysql:host=localhost;dbname=ishyura;charset=utf8';
            $username = 'root'; // Change this to your database username
            $password = ''; // Change this to your database password
            try {
                $this->pdo = new PDO($dsn, $username, $password);
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo 'Connection failed: ' . $e->getMessage();
                exit;
            }
        }

        public function mainMenuRegistered(){
            $response =  "Welcome Ishyura Loan App, Reply with: \n";
            $response .= "1. Pay Loan\n";
            $response .= "2. Paid Amount\n";
            $response .= "3. UnPaid Amount\n";
            echo "CON ". $response;
        }

        public function mainMenuUnregistered(){
            $response = "CON Welcome Ishyura Loan App, reply with:  \n";
            $response .= "1. Register Your Account \n";
            echo $response;
        }

        public function menuRegister($textArray) {
            // Do something
            $level = count($textArray);
            if ($level == 1) {
                echo "CON Enter Your Fullname\n";
            } else if ($level == 2) {
                echo "CON Enter Your REGNO\n";
            } else if ($level == 3) {
                echo "CON Enter Your phoneNumber\n";
            }
            else if ($level == 4) {
                echo "CON Set your PIN\n";
            } else if ($level == 5) {
                echo "CON Re-enter Your PIN\n";
            } else if ($level == 6) {
                $name = $textArray[1];
                $regno = $textArray[2];
                $phoneNumber = $textArray[3]; // Extract phoneNumber from input
                $pin = $textArray[4];
                $confirm_pin = $textArray[5];
                if ($pin != $confirm_pin) {
                    echo "END PINs do not match, Retry";
                } else {
                    // Check if regno already exists in the database
                    $regnoExists = false;
                    try {
                        $checkStmt = $this->pdo->prepare("SELECT COUNT(*) FROM users WHERE regno = :regno");
                        $checkStmt->bindParam(':regno', $regno);
                        $checkStmt->execute();
                        $regnoExists = $checkStmt->fetchColumn() > 0;
                    } catch (PDOException $e) {
                        echo "END Error occurred while checking registration number: " . $e->getMessage();
                        return;
                    }
        
                    if ($regnoExists) {
                        echo "END Registration number already exists. Please choose a different one.";
                        return;
                    }
        
                    // Insert data into the database
                    try {
                        $stmt = $this->pdo->prepare("INSERT INTO users (names, regno, phoneNumber, pin) VALUES (:names, :regno, :phone, :pin)");
                        $stmt->bindParam(':names', $name);
                        $stmt->bindParam(':regno', $regno);
                        $stmt->bindParam(':phone', $phoneNumber);
                        $stmt->bindParam(':pin', $pin);
                        $stmt->execute();
        
                        echo "END $name, You have successfully registered with registration number: $regno";
                    } catch (PDOException $e) {
                        echo "END Error occurred while registering: " . $e->getMessage();
                    }
                }
            } else if ($level == 7) {
                if ($textArray[6] == 98) { // Go back option
                    // Handle go back logic using middleware
                    $text = $this->middleware($textArray[0]);
                    echo $text;
                } else if ($textArray[6] == '99') { // Go to main menu option
                    // Handle go to main menu logic using middleware
                    $text = $this->middleware($textArray[0]);
                    echo $text;
                } else {
                    echo "END Invalid option";
                }
            } else {
                echo "END Invalid entry";
            }
        }
        

        public function menuSendMoney($textArray) {
            // Do something
            $level = count($textArray);
            if ($level == 1) {
                echo "CON Enter Your Regno :";
            } else if ($level == 2) {
                echo "CON Enter bank account of the receiver:";
            } else if ($level == 3) {
                echo "CON Enter amount:";
            } else if ($level == 4) {
                echo "CON Enter your PIN:";
            } else if ($level == 5) {
                if ($textArray[4] == 98) { // Go back option
                    // Handle go back logic using middleware
                    // Assuming you have a middleware function to handle going back
                    $text = $this->middleware($textArray[0]);
                    echo $text;
                    return;
                } else if ($textArray[4] == 99) { // Go to main menu option
                    // Handle go to main menu logic using middleware
                    // Assuming you have a middleware function to handle going to the main menu
                    $text = $this->middlewareMain($textArray[0]); // Adjust the middleware function name as needed
                    echo $text;
                    return;
                }
        
                // Check PIN against user's PIN in the database
                $pin = $textArray[4];
                $regno = $textArray[1]; // Assuming registration number is passed in $textArray[1]
        
                try {
                    $pinCheckStmt = $this->pdo->prepare("SELECT * FROM users WHERE regno = :regno AND pin = :pin");
                    $pinCheckStmt->bindParam(':regno', $regno);
                    $pinCheckStmt->bindParam(':pin', $pin);
                    $pinCheckStmt->execute();
                    $user = $pinCheckStmt->fetch(PDO::FETCH_ASSOC);
        
                    if (!$user) {
                        echo "END Invalid PIN. Please try again.";
                        return;
                    }
                } catch (PDOException $e) {
                    echo "END Error occurred while checking PIN: " . $e->getMessage();
                    return;
                }
        
                // Obtain receiver account from user input
                $receiverAccount = $textArray[2];
        
                // Proceed with inserting into the pay table
                $amount = $textArray[3];
        
                try {
                    $insertStmt = $this->pdo->prepare("INSERT INTO pay (regno, receiverccount, amount) VALUES (:regno, :receiverccount, :amount)");
                    $insertStmt->bindParam(':regno', $regno);
                    $insertStmt->bindParam(':receiverccount', $receiverAccount);
                    $insertStmt->bindParam(':amount', $amount);
                    $insertStmt->execute();
                    echo "END Your request is being processed";
                } catch (PDOException $e) {
                    echo "END Error occurred while processing the request: " . $e->getMessage();
                }
            } else {
                echo "END Invalid entry";
            }
        }
        

        public function menuPaidAmount($textArray) {
            // Do something
            $level = count($textArray);
            if ($level == 1) {
                echo "CON Enter ReGNO\n";
            } else if ($level == 2) {
                if ($textArray[1] == 98) { // Go back option
                    // Handle go back logic using middleware
                    $text = $this->middleware($textArray[0]);
                    echo $text;
                    return;
                } else if ($textArray[1] == 99) { // Go to main menu option
                    // Handle go to main menu logic using middleware
                    $text = $this->middleware($textArray[0]);
                    echo $text;
                    return;
                }
        
                // Retrieve total amount paid and names associated with the entered registration number (regno)
                $regno = $textArray[1]; // Assuming registration number is passed in $textArray[1]
        
                try {
                    $stmt = $this->pdo->prepare("SELECT u.names, SUM(p.amount) AS total_amount 
                                                 FROM users u 
                                                 INNER JOIN pay p ON u.regno = p.regno 
                                                 WHERE u.regno = :regno 
                                                 GROUP BY u.names");
                    $stmt->bindParam(':regno', $regno);
                    $stmt->execute();
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
                    if (!$result) {
                        echo "END No payments found for the given registration number. Please check your details.";
                        return;
                    }
        
                    echo "END Total amount Paid by  {$result['names']} with registration number {$regno} is equal to: {$result['total_amount']}\n";
                } catch (PDOException $e) {
                    echo "END Error occurred while processing the request: " . $e->getMessage();
                }
            } else {
                echo "END Invalid entry";
            }
        }
        
        public function menuUnPaidAmount($textArray) {
            // Do something
            $level = count($textArray);
            if ($level == 1) {
                echo "CON Enter ReGNO\n";
            } else if ($level == 2) {
                if ($textArray[1] == 98) { // Go back option
                    // Handle go back logic using middleware
                    $text = $this->middleware($textArray[0]);
                    echo $text;
                    return;
                } else if ($textArray[1] == 99) { // Go to main menu option
                    // Handle go to main menu logic using middleware
                    $text = $this->middleware($textArray[0]);
                    echo $text;
                    return;
                }
        
                // Retrieve total amount paid and names associated with the entered registration number (regno)
                $regno = $textArray[1]; // Assuming registration number is passed in $textArray[1]
        
                try {
                    $stmt = $this->pdo->prepare("SELECT u.names, SUM(p.amount) AS total_amount 
                                                 FROM users u 
                                                 LEFT JOIN pay p ON u.regno = p.regno 
                                                 WHERE u.regno = :regno 
                                                 GROUP BY u.names");
                    $stmt->bindParam(':regno', $regno);
                    $stmt->execute();
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
                    if (!$result) {
                        echo "END No payments found for the given registration number. Please check your details.";
                        return;
                    }
        
                    // Calculate the unpaid amount by subtracting the fixed amount from the total amount paid
                    $unpaidAmount = 10000000 - $result['total_amount'];
        
                    echo "END  Unpaid amount for {$result['names']} with registration number {$regno} is equal to: {$unpaidAmount}\n";
                } catch (PDOException $e) {
                    echo "END Error occurred while processing the request: " . $e->getMessage();
                }
            } else {
                echo "END Invalid entry";
            }
        }

        public function middleware($text){
            //remove entries for going back and going to the main menu
            return $this->goBack($this->goToMainMenu($text));
        }

        public function goBack($text){
            //1*4*5*1*98*2*1234
            $explodedText = explode("*",$text);
            while(array_search(Util::$GO_BACK, $explodedText) != false){
                $firstIndex = array_search(Util::$GO_BACK, $explodedText);
                array_splice($explodedText, $firstIndex-1, 2);
            }
            return join("*", $explodedText);
        }

        public function goToMainMenu($text){
            //1*4*5*1*99*2*1234*99
            $explodedText = explode("*",$text);
            while(array_search(Util::$GO_TO_MAIN_MENU, $explodedText) != false){
                $firstIndex = array_search(Util::$GO_TO_MAIN_MENU, $explodedText);
                $explodedText = array_slice($explodedText, $firstIndex + 1);
            }
            return join("*",$explodedText);
        }

    }

?>