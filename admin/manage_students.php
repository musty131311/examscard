<?php
include '../includes/db_connect.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

$stmt = $pdo->query("SELECT * FROM students");
$students = $stmt->fetchAll();
?>

<?php include '../includes/header.php'; ?>
<div class="container">
    <h2 class="text-center my-4">Manage Students</h2>
    <table class="table table-striped table-bordered">
        <thead class="table-primary">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Program</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($students as $student): ?>
            <tr>
                <td><?= $student['student_id']; ?></td>
                <td><?= $student['name']; ?></td>
                <td><?= $student['email']; ?></td>
                <td><?= $student['phone']; ?></td>
                <td><?= $student['program']; ?></td>
                <td>
                    <a class="btn btn-warning btn-sm" href="edit_student.php?id=<?= $student['student_id']; ?>">Edit</a>
                    <a class="btn btn-danger btn-sm" href="delete_student.php?id=<?= $student['student_id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
