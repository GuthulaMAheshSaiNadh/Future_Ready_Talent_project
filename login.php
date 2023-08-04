<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Replace with your Azure SQL Database connection details
    $serverName = "futurereadytalent.database.windows.net";
    $database = "FutureReadyTalent";
    $username = "Adminuser";
    $password = "Mahesh@6976";

    try {
        // Create a connection to the database
        $conn = new PDO("sqlsrv:server = tcp:$serverName,1433; Database = $database", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Retrieve user input
        $username = $_POST["username"];
        $password = $_POST["password"];

        // Prepare and execute the SQL select statement
        $sql = "SELECT * FROM Users WHERE Username = :username";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":username", $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['Password'])) {
            // Authentication successful
            echo "Login successful. Welcome, " . $user['Username'] . "!";
        } else {
            // Authentication failed
            echo "Invalid username or password.";
        }
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}
?>
