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
        $password = password_hash($_POST["password"], PASSWORD_BCRYPT); // Hash the password
        $email = $_POST["email"];

        // Prepare and execute the SQL insert statement
        $sql = "INSERT INTO Users (Username, Password, Email) VALUES (:username, :password, :email)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":password", $password);
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        echo "Registration successful! Welcome, $username!";
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}
?>
