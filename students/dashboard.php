<?php
include '../includes/db_connect.php';
session_start();

if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit;
}

$student_id = $_SESSION['student_id'];
$stmt = $pdo->prepare("SELECT s.student_id, s.name, s.email, s.phone, s.photo, s.program, s.course_ids
                       FROM students s
                       WHERE s.student_id = ?");
$stmt->execute([$student_id]);
$student = $stmt->fetch();

// Fetch course details for selected courses
$selected_courses = !empty($student['course_ids']) ? explode(',', $student['course_ids']) : [];
$courses = [];
if (!empty($selected_courses)) {
    $placeholders = rtrim(str_repeat('?,', count($selected_courses)), ',');
    $course_stmt = $pdo->prepare("SELECT course_code, course_name, exam_date, exam_time, venue FROM examinations WHERE exam_id IN ($placeholders)");
    $course_stmt->execute($selected_courses);
    $courses = $course_stmt->fetchAll();
}
?>

<?php include '../includes/header.php'; ?>
<div class="container mt-5">
    <h2 class="text-center mb-4">Student Dashboard</h2>
    <div class="row">
        <!-- Student Profile Section -->
        <div class="col-md-4">
            <div class="card shadow">
                <img src="<?= htmlspecialchars($student['photo']); ?>" alt="Student Photo" class="card-img-top img-thumbnail" onerror="this.src='../assets/default-profile.png';">
                <div class="card-body text-center">
                    <h5 class="card-title"><?= htmlspecialchars($student['name']); ?></h5>
                    <p><strong>Student ID:</strong> <?= htmlspecialchars($student['student_id']); ?></p>
                    <p><strong>Email:</strong> <?= htmlspecialchars($student['email']); ?></p>
                    <p><strong>Phone:</strong> <?= htmlspecialchars($student['phone']); ?></p>
                    <p><strong>Program:</strong> <?= htmlspecialchars($student['program']); ?></p>
                </div>
            </div>
        </div>

        <!-- Examination Details Section -->
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white text-center">
                    <h5>Examination Details</h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($courses)): ?>
                        <table class="table table-bordered table-striped">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th>Course Code</th>
                                    <th>Course Title</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Venue</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($courses as $course): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($course['course_code']); ?></td>
                                        <td><?= htmlspecialchars($course['course_name']); ?></td>
                                        <td><?= htmlspecialchars($course['exam_date']); ?></td>
                                        <td><?= htmlspecialchars($course['exam_time']); ?></td>
                                        <td><?= htmlspecialchars($course['venue']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p class="text-danger text-center">You have not registered for any courses yet.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions Section -->
    <div class="mt-4 text-center">
        <a href="generate_card.php" class="btn btn-success me-2"><i class="fas fa-eye"></i> View Exam Card</a>
        <a href="download_card.php" class="btn btn-primary me-2"><i class="fas fa-download"></i> Download Exam Card (PDF)</a>
        <button class="btn btn-warning" onclick="window.print()"><i class="fas fa-print"></i> Print Exam Card</button>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
