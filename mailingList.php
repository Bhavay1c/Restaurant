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

                <div class="main">
                    <h1>Mailing List</h1>
                    <?php
// Database connection setup
require_once "db_config.php";

try {
    // Create a PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare and execute the SELECT query
    $sqlQuery = "SELECT * FROM mailingList";
    $stmt = $pdo->query($sqlQuery);

    // Display the results in a table
    echo "<table>
            <tr>
                <th>Full Name</th>
                <th>Email Address</th>
                <th>Phone Number</th>
            </tr>";

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . $row["firstName"] . " " . $row["lastName"] . "</td>";
        echo "<td>" . $row["emailAddress"] . "</td>";
        echo "<td>" . $row["phoneNumber"] . "</td>";
        
        echo "</tr>";
    }

    echo "</table>";
} catch (PDOException $e) {
    // Handle database connection error
    echo "Database error: " . $e->getMessage();
}

// Close the database connection
unset($pdo);
?>

                </div><!-- End Main -->
            </div><!-- End Content -->

<?php 
include 'footer.php';
?>
       