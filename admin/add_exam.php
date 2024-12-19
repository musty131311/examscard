<?php
include '../includes/db_connect.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $course_name = $_POST['course_name'];
    $exam_date = $_POST['exam_date'];
    $exam_time = $_POST['exam_time'];
    $venue = $_POST['venue'];

    try {
        $stmt = $pdo->prepare("INSERT INTO examinations (course_name, exam_date, exam_time, venue) VALUES (?, ?, ?, ?)");
        $stmt->execute([$course_name, $exam_date, $exam_time, $venue]);
        echo "<div class='alert alert-success text-center'>Examination added successfully!</div>";
    } catch (PDOException $e) {
        echo "<div class='alert alert-danger text-center'>Error: " . $e->getMessage() . "</div>";
    }
}
?>

<?php include '../includes/header.php'; ?>
<div class="container">
    <h2 class="text-center my-4">Add Examination</h2>
    <form action="" method="POST" class="mx-auto" style="max-width: 400px;">
        <div class="mb-3">
            <label for="course_name" class="form-label">Course Name</label>
            <input type="text" name="course_name" id="course_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="exam_date" class="form-label">Exam Date</label>
            <input type="date" name="exam_date" id="exam_date" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="exam_time" class="form-label">Exam Time</label>
            <input type="time" name="exam_time" id="exam_time" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="venue" class="form-label">Venue</label>
            <input type="text" name="venue" id="venue" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Add Exam</button>
    </form>
</div>
