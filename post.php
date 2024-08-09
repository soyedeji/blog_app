<?php

/*******w******** 
    
    Name: Samuel Oyedeji
    Date: 2024-06-10
    Description: Blog post creation and viewing with edit link functionality.

****************/

require 'connect.php';
require 'authenticate.php';  // This ensures authentication is required for accessing edit.php

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $stmt = $pdo->prepare("SELECT title, content, created_at FROM posts WHERE id = ?");
    $stmt->execute([$id]);
    $post = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    if ($title && $content) {
        $stmt = $pdo->prepare("INSERT INTO posts (title, content) VALUES (?, ?)");
        $stmt->execute([$title, $content]);
        header('Location: index.php');
        exit;
    } else {
        $error = 'Title and content are required';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title><?php echo isset($post) ? htmlspecialchars($post['title']) : 'New Post'; ?></title>
</head>
<body>
    <header>
        <div class="container">
            <h1><a href="index.php">Blog Home</a></h1>
            <h2><?php echo isset($post) ? htmlspecialchars($post['title']) : 'New Post'; ?></h2>
        </div>
    </header>
    <div class="container">
        <?php if (isset($post)): ?>
            <div class="blog-post">
                <h2>
                    <?php echo htmlspecialchars($post['title']); ?>
                    <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']): ?>
                        <a class="edit-link" href="edit.php?id=<?php echo $id; ?>">edit</a>
                    <?php endif; ?>
                </h2>
                <p><?php echo date("F d, Y, h:i a", strtotime($post['created_at'])); ?></p>
                <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
            </div>
        <?php else: ?>
            <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']): ?>
                <form action="post.php" method="post" class="form">
                    <label for="title">Title:</label>
                    <input type="text" id="title" name="title" required>
                    <label for="content">Content:</label>
                    <textarea id="content" name="content" required></textarea>
                    <button type="submit">Submit</button>
                </form>
                <?php if (isset($error)): ?>
                    <p><?php echo $error; ?></p>
                <?php endif; ?>
            <?php endif; ?>
        <?php endif; ?>
    </div>
    <footer>
        <p>Blog &copy; 2024</p>
    </footer>
</body>
</html>
