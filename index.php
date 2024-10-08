<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cv_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['create'])) {
        // Create (Insert)
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $skills = $_POST['skills'];
        $education = $_POST['education'];
        $experience = $_POST['experience'];

        $sql = "INSERT INTO cv_info (name, email, phone, skills, education, experience) VALUES ('$name', '$email', '$phone', '$skills', '$education', '$experience')";

        if ($conn->query($sql) === TRUE) {
            echo "New CV record created successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

    } elseif (isset($_POST['update'])) {
        // Update
        $id = $_POST['id'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];

        $sql = "UPDATE cv_info SET name='$name', email='$email', phone='$phone' WHERE id=$id";

        if ($conn->query($sql) === TRUE) {
            echo "Record updated successfully!";
        } else {
            echo "Error updating record: " . $conn->error;
        }

    } elseif (isset($_POST['delete'])) {
        // Delete
        $id = $_POST['id'];

        $sql = "DELETE FROM cv_info WHERE id=$id";

        if ($conn->query($sql) === TRUE) {
            echo "Record deleted successfully!";
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV CRUD</title>
</head>
<body>

<h1>CV Form</h1>
<form action="index.php" method="post">
    <input type="text" name="name" placeholder="Name" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="text" name="phone" placeholder="Phone" required><br>
    <textarea name="skills" placeholder="Skills" required></textarea><br>
    <textarea name="education" placeholder="Education" required></textarea><br>
    <textarea name="experience" placeholder="Experience" required></textarea><br>
    <button type="submit" name="create">Submit</button>
</form>

<h1>Update or Delete CV</h1>
<form action="index.php" method="post">
    <input type="number" name="id" placeholder="ID" required><br>
    <input type="text" name="name" placeholder="Name"><br>
    <input type="email" name="email" placeholder="Email"><br>
    <input type="text" name="phone" placeholder="Phone"><br>
    <button type="submit" name="update">Update</button>
    <button type="submit" name="delete">Delete</button>
</form>

<h1>CV List</h1>
<?php
// Read (Display data)
$sql = "SELECT * FROM cv_info";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "ID: " . $row["id"] . " - Name: " . $row["name"] . " - Email: " . $row["email"] . " - Phone: " . $row["phone"] . "<br>";
    }
} else {
    echo "No records found!";
}
$conn->close();
?>

</body>
</html>
