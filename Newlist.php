<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "work";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}

// Handle item deletion
if (isset($_GET["action"]) && $_GET["action"] === "supprimer" && isset($_GET["id"])) {
    $itemId = $_GET["id"];
    $deleteSql = "DELETE FROM itulisa WHERE id = $itemId";

    if ($conn->query($deleteSql) === TRUE) {
        echo "Item supprimé avec succès.";
    } else {
        echo "Erreur lors de la suppression : " . $conn->error;
    }
}

// Handle item modification - you need to implement the modification logic here

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process the form data
    $titre = $_POST["titre"];
    $descriptionn = $_POST["descriptions"];

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
    $sql = "INSERT INTO itulisa (titre, descriptions, imagee) VALUES ('$titre', '$descriptions', '$targetFilePath')";

    if ($conn->query($sql) === TRUE) {
        echo "Connexion réussie";
    } else {
        echo "Erreur : " . $conn->error;
    }
}

// Fetch items from the database
$selectSql = "SELECT * FROM itulisa";
$result = $conn->query($selectSql);
?>



    <h2>Liste des éléments</h2>

    <table border="1">
        <tr>
            <th>Titre</th>
            <th>Description</th>
            <th>Image</th>
            <th>Actions</th>
        </tr>
        <?php
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["titre"] . "</td>";
            echo "<td>" . $row["descriptions"] . "</td>";
            echo "<td><img src='" . $row["imagee"] . "' alt='Image'></td>";
            echo "<td>";
            echo "<a href='?action=supprimer&id=" . $row["id"] . "'>Supprimer</a>";
           
            // You can add a link for modifying an item, for example:
             echo " <a href='modify.php?id=" . $row["id"] . "'>Modifier</a>";
            echo "</td>";
            echo "</tr>";
        }
        ?>
    </table>

</body>

</html>

<?php
$conn->close();
?>
