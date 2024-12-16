<?php

$hostname = "localhost";
$username = "root";
$password = "";
$database = "sensor_db";

// Establish database connection
$conn = mysqli_connect($hostname, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if both elapsedTime and name are set in the POST request
if (isset($_POST["elapsedTime"]) && isset($_POST["name"])) {
    
    // Sanitize the elapsedTime and name inputs
    $name = $_POST['name'];
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    
    // Prepare the SQL statement to insert both elapsedTime and name
    $stmt = $conn->prepare("INSERT INTO dht11 (elapsedTime, name) VALUES (?, ?)");
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    // Bind the elapsedTime (double) and name (string) parameters
    $stmt->bind_param("ds", $e, $name);

    // Execute the statement
    if ($stmt->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();

?>
