<?php
// PDO savienojums ar datubāzi
$servername = "localhost";
$username = "bob_69"; // Vai jūsu MySQL lietotājvārds
$password = "password"; // Ja parole ir nepieciešama, ievadiet to šeit
$dbname = "blog_12032025";

try {
    // Izveidojam savienojumu
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Iestata režīmu, lai metodes izmestu izņēmumus (error handling)
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Savienojuma kļūda: " . $e->getMessage();
}

// Apstrādājam formu, ja tā tiek nosūtīta
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];

    // Sagatavojam SQL vaicājumu
    $sql = "INSERT INTO posts (title, content) VALUES (:title, :content)";
    
    // Sagatavojam izpildi
    $stmt = $conn->prepare($sql);
    
    // Pievienojam parametrus
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':content', $content);
    
    // Izpildām vaicājumu
    try {
        $stmt->execute();
        echo "Jaunais raksts ir veiksmīgi pievienots!";
    } catch (PDOException $e) {
        echo "Kļūda pievienojot rakstu: " . $e->getMessage();
    }
}

// Aizveram savienojumu
$conn = null;
?>

<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Izveidot jaunu rakstu</title>
</head>
<body>
    <h1>Izveidot jaunu rakstu</h1>
    <form method="POST" action="new-post.php">
        <label for="title">Raksta nosaukums:</label><br>
        <input type="text" id="title" name="title" required><br><br>

        <label for="content">Raksta saturs:</label><br>
        <textarea id="content" name="content" rows="4" cols="50" required></textarea><br><br>

        <input type="submit" value="Pievienot rakstu">
    </form>
</body>
</html>
