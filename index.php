<?php

/*******w******** 

    Name: Samuel Oyedeji
    Date: 2024-0610
    Description: Blog Post

****************/

require 'connect.php';
session_start();

$query = "SELECT id, title, content, created_at FROM posts ORDER BY created_at DESC LIMIT 5";
$result = $pdo->query($query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Welcome to my blog</title>
</head>
<body>
    <header>
        <div class="container">
        <h1><a href="index.php">Blog Home</a></h1>
        <h2><a class="post-link" href="post.php">New Post</a></h2>
        </div>
    </header>
    <div class="container">
        <?php while ($row = $result->fetch(PDO::FETCH_ASSOC)): ?>
            <div class="blog-post">
                <h2><a href="post.php?id=<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['title']); ?></a></h2>
                <p><?php echo date("F d, Y, h:i a", strtotime($row['created_at'])); ?></p>
                <p>
                    <?php
                    $content = $row['content'];
                    if (strlen($content) > 200) {
                        echo htmlspecialchars(substr($content, 0, 200)) . '... <a href="post.php?id=' . $row['id'] . '">Read Full Post</a>';
                    } else {
                        echo htmlspecialchars($content);
                    }
                    ?>
                </p>
                <a class="edit-link" href="edit.php?id=<?php echo $row['id']; ?>">edit</a>
            </div>
        <?php endwhile; ?>
    </div>
    <footer>
        <p>Blog &copy; 2024</p>
    </footer>
</body>
</html>
