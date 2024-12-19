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
    <div class="card mx-auto shadow-lg" style="max-width: 900px; border: 2px solid #0d6efd; padding: 20px;">
        <!-- Header Section -->
        <div class="d-flex align-items-center justify-content-between mb-4">
            <img src="../assets/uploads/logo.png" alt="College Logo" style="width: 100px; height: 100px;">
            <div class="text-center">
                <h3 class="text-primary mb-0">Jigawa State College of Nursing and Midwifery</h3>
                <p class="text-secondary mb-0"><strong>Examination Card</strong></p>
            </div>
            <div></div> <!-- Empty div for balance -->
        </div>
        <hr style="border: 2px solid #0d6efd;">
        
        <!-- Student Details -->
        <div class="row mb-4">
            <div class="col-md-4 text-center">
                <img src="<?= htmlspecialchars($student['photo']); ?>" alt="Student Photo" class="img-thumbnail border-primary" onerror="this.src='../assets/default-profile.png';" style="width: 150px; height: 150px;">
            </div>
            <div class="col-md-8">
                <p><strong>Name:</strong> <?= htmlspecialchars($student['name']); ?></p>
                <p><strong>Student ID:</strong> <?= htmlspecialchars($student['student_id']); ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($student['email']); ?></p>
                <p><strong>Phone:</strong> <?= htmlspecialchars($student['phone']); ?></p>
                <p><strong>Program:</strong> <?= htmlspecialchars($student['program']); ?></p>
            </div>
        </div>
        
        <!-- Examination Details -->
        <h5 class="text-center text-primary mb-3">Examination Details</h5>
        <?php if (!empty($courses)): ?>
            <table class="table table-bordered table-striped" style="width: 100%; font-size: 14px;">
                <thead class="bg-primary text-white">
                    <tr>
                        <th style="width: 20%;">Course Code</th>
                        <th style="width: 40%;">Course Title</th>
                        <th style="width: 15%;">Exam Date</th>
                        <th style="width: 15%;">Time</th>
                        <th style="width: 10%;">Venue</th>
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
            <p class="text-danger text-center">No courses registered.</p>
        <?php endif; ?>
        
        <!-- Signature Section -->
        <div class="row mt-4">
            <div class="col-md-6 text-center">
                <p><strong>Registrar's Signature:</strong></p>
                <img src="../assets/uploads/signature.png" alt="Registrar Signature" style="width: 150px; height: 50px;">
            </div>
            <div class="col-md-6 text-center">
                <p><strong>Date of Issue:</strong> <?= date('Y-m-d'); ?></p>
            </div>
        </div>

        <!-- Footer Notes -->
        <hr>
        <p class="text-center text-muted">
            Note: This card is required to gain access to the examination hall. Please bring it along with a valid ID card.
        </p>
        
        <!-- Buttons for Download and Print -->
        <div class="text-center mt-4">
            <a href="download_card.php" class="btn btn-primary"><i class="fas fa-download"></i> Download PDF</a>
            <button class="btn btn-success" onclick="window.print()"><i class="fas fa-print"></i> Print</button>
        </div>
    </div>
</div>

<style>
/* Ensure A4 Size for Printing */
@media print {
    body {
        width: 210mm;
        height: 297mm;
    }
    .card {
        page-break-inside: avoid;
    }
}
</style>
