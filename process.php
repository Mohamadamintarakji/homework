<?php
// Database connection details
$servername = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "your_database_name";

// Create a connection to MySQL
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $fullName = $_POST["fullName"];
    $email = $_POST["email"];
    $gender = $_POST["gender"];

    // Validate form data
    // ... perform your validation logic here

    // If the data is valid, insert into the database
    $sql = "INSERT INTO students (full_name, email, gender) VALUES ('$fullName', '$email', '$gender')";
    if ($conn->query($sql) === TRUE) {
        echo "Data inserted successfully!";
    } else {
        echo "Error inserting data: " . $conn->error;
    }
}

// Retrieve and display student information from the database
$sql = "SELECT * FROM students";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h2>Registered Students:</h2>";
    echo "<table>";
    echo "<tr><th>ID</th><th>Full Name</th><th>Email</th><th>Gender</th></tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["id"] . "</td>";
        echo "<td>" . $row["full_name"] . "</td>";
        echo "<td>" . $row["email"] . "</td>";
        echo "<td>" . $row["gender"] . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "No students registered yet.";
}

// Close the database connection
$conn->close();
?>
