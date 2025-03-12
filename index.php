<?php

$servername = "localhost";
$username = "bob_69"; // Vai jūsu MySQL lietotājvārds
$password = "password"; // Ja parole ir nepieciešama, ievadiet to šeit
$dbname = "blog_12032025";

try {
    // Izveido PDO savienojumu
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SQL vaicājums, lai iegūtu visus ierakstus no 'posts' tabulas
    $stmt = $pdo->query("SELECT * FROM posts p left join comments c on p.post_id = c.post_id");

    // Iegūst visus ierakstus kā asociatīvo masīvu
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    die("Savienojuma kļūda: " . $e->getMessage());
}

?>

<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bloga ieraksti</title>
</head>
<body>
    <h1>Bloga ieraksti</h1>
    <?php if (!empty($posts)): ?>
        <ul>
            <?php foreach ($posts as $post): ?>
                <li>
                    <strong><?= htmlspecialchars($post['title']) ?></strong><br>
                    <?= nl2br(htmlspecialchars($post['content'])) ?><br>
                    <em>Izveidots: <?= $post['created_at'] ?></em>
                </li>
                <hr>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Nav pieejamu ierakstu.</p>
    <?php endif; ?>
</body>
</html>
