<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "work";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process the form data
    $titre = $_POST["titre"];
    $description = $_POST["descriptionn"]; // corrected variable name

    // Create the "uploads" directory if it doesn't exist
    $targetDir = "uploads/";
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }

    // Process the uploaded image
    $imageName = basename($_FILES["image"]["name"]);
    $targetFilePath = $targetDir . $imageName;
    move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath);

    // Insert data into the database
    $sql = "INSERT INTO itulisa (titre, descriptions, imagee) VALUES ('$titre', '$description', '$targetFilePath')"; // corrected variable name

    if ($conn->query($sql) === TRUE) {
        echo "connexion succès";
    } else {
        echo "Erreur  : " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Item</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
        <label for="titre">Titre :</label>
        <input type="text" id="titre" name="titre" value="Default Title" required>

        <label for="descriptionn">Description :</label>
        <textarea id="descriptionn" name="descriptionn" rows="4" required>Default Description</textarea>

        <label for="image">Choisir une image :</label>
        <input type="file" id="image" name="image" accept="image/*" required>

        <input type="submit" value="Submit">
    </form>

</body>

</html>
