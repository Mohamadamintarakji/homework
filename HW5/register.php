<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "students";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the table exists
$tableName = "students";
$tableExists = false;
$result = $conn->query("SHOW TABLES LIKE '$tableName'");
if ($result->num_rows > 0) {
    $tableExists = true;
}

// Create the table if it doesn't exist
if (!$tableExists) {
    $sql = "CREATE TABLE students (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        full_name VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL,
        gender ENUM('Male', 'Female') NOT NULL
    )";

    if ($conn->query($sql) === TRUE) {
        echo "Table 'students' created successfully";
    } else {
        echo "Error creating table: " . $conn->error;
    }
}

// Validate form data and insert into the database
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST["full_name"];
    $email = $_POST["email"];
    $gender = $_POST["gender"];

    // Insert data into the database
    $sql = "INSERT INTO students (full_name, email, gender) VALUES ('$full_name', '$email', '$gender')";

    if ($conn->query($sql) === TRUE) {
        echo "Data inserted successfully!";

        // Retrieve the inserted student's information
        $lastInsertId = $conn->insert_id;
        $selectSql = "SELECT * FROM students WHERE id = $lastInsertId";
        $result = $conn->query($selectSql);

        if ($result->num_rows > 0) {
            echo "<h2>Newly Inserted Student:</h2>";
            echo "<table>";
            echo "<tr><th>ID</th><th>Full Name</th><th>Email</th><th>Gender</th></tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "  <td>" . $row['full_name'] . "</td>";
                echo "  <td>" . $row['email'] . "</td>";
                echo "  <td>" . $row['gender'] . "</td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "No student found";
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
