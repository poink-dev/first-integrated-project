<?php
session_start();
$hostname = "localhost";
$username = "root";
$password = "";
$database = "sensor_db";

// Establish database connection
$conn = mysqli_connect($hostname, $username, $password, $database);

$response = array();

// Prepare and execute the SQL statement to retrieve elapsedTime
$sql = "SELECT `elapsedTime` FROM `dht11` ORDER BY createdAt DESC LIMIT 1"; // Retrieves the most recent elapsedTime
$statement = $conn->prepare($sql);
$statement->execute();
$results = $statement->get_result();
$row = $results->fetch_assoc();

// Store the retrieved elapsedTime in the response and session
$response = $row;
$_SESSION['elapsedTime'] = $row['elapsedTime'];

// Output the response as JSON
echo json_encode($response);

// Close the statement and connection
$statement->close();
$conn->close();
?>
