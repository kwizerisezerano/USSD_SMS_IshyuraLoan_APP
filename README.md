# USSD_SMS_IshyuraLoan_APP
https://github.com/kwizerisezerano/USSD_SMS_IshyuraLoan_APP
 Project Overview
This project is a USSD-based application designed for a BRD Bursary loan management system called Ishyura Loan App. It enables users to register, send money, view paid and unpaid loan amounts, and more—all via their mobile phones. Below is a detailed overview of the project's key components and their functions.

Project Structure
index.php: This is the main entry point for the USSD service. It receives inputs from the USSD gateway and determines the appropriate response based on user inputs and session information.
menu.php: This file defines the various menu options and functionality for the USSD service. It handles the main menu, registration process, sending money, and other interactions based on the user’s inputs.
sms.php: This file handles SMS-based registration. It receives SMS messages with user details and registers the user if the phone number is not already registered.
util.php: file defines a utility class named Util that contains static constants used throughout the USSD-based loan management system. The class provides commonly used values that represent specific commands for navigating the USSD menus.

index.php: USSD Handling
The index.php file receives inputs from a USSD gateway, which includes sessionId, phoneNumber, serviceCode, and text.
It establishes a connection to a MySQL database and checks whether the user with the given phone number is already registered in the users table.
Based on the text and registration status, it calls the appropriate menu handling methods from menu.php.
If the user is not registered, the main menu offers a registration option. If registered, it presents other options like sending money, checking paid amounts, and unpaid amounts.
menu.php: USSD Menu Handling
The Menu class in menu.php defines various methods for handling the USSD menu interactions.
It establishes a connection to the MySQL database for database operations.
The mainMenuRegistered and mainMenuUnregistered methods define the main menu options based on the registration status.
The menuRegister method handles the registration process, asking users for their full name, registration number, phone number, and PIN.
Other methods, like menuSendMoney, menuPaidAmount, and menuUnPaidAmount, provide further functionality for users to interact with the loan application system.
It uses middleware, goBack, and goToMainMenu methods to manage navigation and maintain the user session.

sms.php: SMS-Based Registration Handling
The sms.php file handles SMS-based user registration.
It receives SMS data from a gateway, including the phone number of the sender (from) and the message text (text).
The text is expected to contain user information in the format "name regno pin".
The script establishes a connection to the MySQL database to interact with the users table.
It checks if the phone number already exists in the users table. If not, it inserts a new record with the provided information.
If the user is already registered, it returns an appropriate message. Otherwise, it completes the registration and responds with a success message, providing the registered information.
If any fields are missing, it prompts the user to complete the missing information.
util.php: ussd utilHandling
Static Constants:
The Util class has two static variables: $GO_BACK and $GO_TO_MAIN_MENU.
These constants represent specific USSD codes for navigating within the USSD application.
$GO_BACK ("98"): Represents the command to "go back" in the USSD menu. When users input this code, it signals the system to navigate back to a previous menu or option.
$GO_TO_MAIN_MENU ("99"): Represents the command to "go to the main menu." This code allows users to return to the initial menu, providing a way to restart or reset their interaction with the system.
Usage in USSD Menus:
The Util constants are used in the menu.php file to identify user inputs for navigating back or returning to the main menu.
Functions in menu.php, like goBack and goToMainMenu, utilize these constants to manage navigation within the USSD menus. These functions remove or adjust sections of the input text based on these codes, ensuring the user's desired action is correctly processed.
