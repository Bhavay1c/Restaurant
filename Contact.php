<?php 
include 'Header.php';
include 'Menu.php';
include 'connect.php';
?>

            <div id="content" class="clearfix">
                <aside>
                        <h2>Mailing Address</h2>
                        <h3>1385 Woodroffe Ave<br>
                            Ottawa, ON K4C1A4</h3>
                        <h2>Phone Number</h2>
                        <h3>(613)727-4723</h3>
                        <h2>Fax Number</h2>
                        <h3>(613)555-1212</h3>
                        <h2>Email Address</h2>
                        <h3>info@wpeatery.com</h3>
                </aside>

                <?php
session_start();

$error = false;
$errorMessage = "";
$missingFields = [];

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and store form input data in session variables
    if (!empty($_POST["customerfName"])) {
        $_SESSION["firstName"] = $_POST["customerfName"];
    } else {
        $error = true;
        $missingFields[] = "First Name";
    }

    if (!empty($_POST["customerlName"])) {
        $_SESSION["lastName"] = $_POST["customerlName"];
    } else {
        $error = true;
        $missingFields[] = "Last Name";
    }

    if (!empty($_POST["phoneNumber"])) {
        $_SESSION["phone"] = $_POST["phoneNumber"];
    } else {
        $error = true;
        $missingFields[] = "Phone Number";
    }

    if (!empty($_POST["emailAddress"])) {
        $_SESSION["email"] = $_POST["emailAddress"];
    } else {
        $error = true;
        $missingFields[] = "Email Address";
    }

    if (!empty($_POST["username"])) {
        $_SESSION["username"] = $_POST["username"];
    } else {
        $error = true;
        $missingFields[] = "Username";
    }

    if (!empty($_POST["referral"]) && $_POST["referral"] != "Select referer") {
        $_SESSION["referral"] = $_POST["referral"];
    } else {
        $error = true;
        $missingFields[] = "Referrer";
    }
    
if (!empty($errorMessage)) {
    $errorMessage= "Fill all the fields.";
    echo "<p style='color: red;'>$errorMessage</p>";
}

    // If there are no missing fields, proceed with database operation
    if (!$error) {
        try {
            // Database connection setup
        $servername = "localhost";
        $username = "ukgvehvrmw4he";
        $password = "Bhavay@123";
        $dbname = "dberbcw9dgkvwt";

            $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


            // Check email address validity
            if (!filter_var($_POST['emailAddress'], FILTER_VALIDATE_EMAIL)) {
                $errorMessage = "Invalid email address";
                echo "<p style='color: red;'>$errorMessage</p>";
            } else {
                // Prepare and execute a SELECT query to check if the email is already in use
                $sqlQuery = "SELECT COUNT(*) FROM `mailingList` WHERE `emailAddress` = ?";
                $stmt = $pdo->prepare($sqlQuery);
                $stmt->execute([$_POST['emailAddress']]);
                $rowCount = $stmt->fetchColumn();

                if ($rowCount > 0) {
                    $errorMessage = "This email is already being used for the mailing list";
                    echo "<p style='color: red;'>$errorMessage</p>";
                } else {
                    // Prepare and execute an INSERT query to add the user to the mailing list
                    $sqlQuery = "INSERT INTO mailingList (firstName, lastName, phoneNumber, emailAddress, userName, referrer) VALUES (?, ?, ?, ?, ?, ?)";
                    $stmt = $pdo->prepare($sqlQuery);
                    $stmt->execute([$_SESSION["firstName"], $_SESSION["lastName"], $_SESSION["phone"], $_SESSION["email"], $_SESSION["username"], $_SESSION["referral"]]);
                    $errorMessage = "Added successfully";
                    echo "<p style='color: red;'>$errorMessage</p>";
                }
            }
        } catch (PDOException $e) {
            $errorMessage = "Database error: " . $e->getMessage();
            echo "<p style='color: red;'>$errorMessage</p>";
        }
    } else {
        $errorMessage = "Please fill the following fields: " . implode(', ', $missingFields);
        echo "<p style='color: red;'>$errorMessage</p>";
    }
}
?>

                <div class="main">
                    <h1>Sign up for our newsletter</h1>
                    <p>Please fill out the following form to be kept up to date with news, specials, and promotions from the WP eatery!</p>
                    <form name="frmNewsletter" id="frmNewsletter" method="post" action="Contact.php">
                        <table>
                            <tr>
                                <td>First Name:</td>
                                <td><input type="text" name="customerfName" id="customerfName" size='40'></td>
                            </tr>
                            <tr>
                                <td>Last Name:</td>
                                <td><input type="text" name="customerlName" id="customerlName" size='40'></td>
                            </tr>
                            <tr>
                                <td>Phone Number:</td>
                                <td><input type="text" name="phoneNumber" id="phoneNumber" size='40'></td>
                            </tr>
                            <tr>
                                <td>Email Address:</td>
                                <td><input type="text" name="emailAddress" id="emailAddress" size='40'>
                            </tr>
                             <tr>
                                <td>Username:</td>
                                <td><input type="text" name="username" id="username" size='20'>
                            </tr>
                            <tr>
                                <td>How did you hear<br> about us?</td>
                                <td>
                                   <select name="referral" size="1">
                                      <option>Select referer</option>
                                      <option value="newspaper">Newspaper</option>
                                      <option value="radio">Radio</option>
                                      <option value="tv">Television</option>
                                      <option value="other">Other</option>
                                   </select>
                                </td>
                            </tr>
                            <tr>
                                <td colspan='2'><input type='submit' name='btnSubmit' id='btnSubmit' value='Sign up!'>&nbsp;&nbsp;<input type='reset' name="btnReset" id="btnReset" value="Reset Form"></td>
                            </tr>
                        </table>
                    </form>
                </div><!-- End Main -->
            </div><!-- End Content -->

<?php 
include 'Footer.php';
?>
       

