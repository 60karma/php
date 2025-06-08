<?php
require 'auth.php';
require 'db.php';


if (isset($_POST['add'])) {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $year = $_POST['year'];

    $stmt = $conn->prepare("INSERT INTO books (title, author, publication_year) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $title, $author, $year);
    $stmt->execute();
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM books WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}


$edit_book = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $result = $conn->query("SELECT * FROM books WHERE id = $id");
    $edit_book = $result->fetch_assoc();
}


if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $year = $_POST['year'];

    $stmt = $conn->prepare("UPDATE books SET title=?, author=?, publication_year=? WHERE id=?");
    $stmt->bind_param("ssii", $title, $author, $year, $id);
    $stmt->execute();

    header("Location: books.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Book List</h2>
<a href="dashboard.php">← Back</a>
<table border="1">
    <tr>
        <th>Title</th>
        <th>Author</th>
        <th>Year</th>
        <th>Actions</th>
    </tr>

    <?php
    $books = $conn->query("SELECT * FROM books");
    while ($row = $books->fetch_assoc()):
    ?>
        <tr>
            <td><?= htmlspecialchars($row['title']) ?></td>
            <td><?= htmlspecialchars($row['author']) ?></td>
            <td><?= $row['publication_year'] ?></td>
            <td>
                <a href="?edit=<?= $row['id'] ?>">Edit</a>
                <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('Delete this book?')">Delete</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>

<hr>

<h2><?= $edit_book ? 'Edit Book' : 'Add New Book' ?></h2>
<form method="POST">
    <?php if ($edit_book): ?>
        <input type="hidden" name="id" value="<?= $edit_book['id'] ?>">
    <?php endif; ?>

    <input type="text" name="title" placeholder="Title" required value="<?= $edit_book['title'] ?? '' ?>"><br>
    <input type="text" name="author" placeholder="Author" required value="<?= $edit_book['author'] ?? '' ?>"><br>
    <input type="number" name="year" placeholder="Year" required value="<?= $edit_book['publication_year'] ?? '' ?>"><br>

    <button type="submit" name="<?= $edit_book ? 'update' : 'add' ?>">
        <?= $edit_book ? 'Update' : 'Add' ?> Book
    </button>
</form>
</body>
</html>
