<?php
include '../includes/db_connect.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// Fetch statistics
$student_count = $pdo->query("SELECT COUNT(*) FROM students")->fetchColumn();
$course_count = $pdo->query("SELECT COUNT(*) FROM examinations")->fetchColumn();
?>

<?php include '../includes/header.php'; ?>
<div class="container mt-5">
    <h2 class="text-center mb-4">Admin Dashboard</h2>
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card bg-primary text-white shadow">
                <div class="card-body text-center">
                    <h5>Registered Students</h5>
                    <h3><?= $student_count; ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white shadow">
                <div class="card-body text-center">
                    <h5>Available Courses</h5>
                    <h3><?= $course_count; ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-warning text-white shadow">
                <div class="card-body text-center">
                    <h5>Upcoming Exams</h5>
                    <h3>12</h3> <!-- Replace with dynamic data -->
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Navigation -->
    <div class="row">
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-body text-center">
                    <h5>Manage Students</h5>
                    <a href="manage_students.php" class="btn btn-primary w-100">View Students</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-body text-center">
                    <h5>Manage Courses</h5>
                    <a href="manage_courses.php" class="btn btn-success w-100">View Courses</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-body text-center">
                    <h5>Manage Exams</h5>
                    <a href="manage_exams.php" class="btn btn-warning w-100">View Exams</a>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center mt-4">
        <a href="logout.php" class="btn btn-danger"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
</div>
<?php include '../includes/footer.php'; ?>
