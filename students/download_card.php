<?php
require '../vendor/autoload.php';
use Dompdf\Dompdf;

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

// Split selected courses into an array
$selected_courses = !empty($student['course_ids']) ? explode(',', $student['course_ids']) : [];

// Generate PDF
<<<<<<< Tabnine <<<<<<<
$dompdf = new Dompdf();//-
$dompdf = new Dompdf\Dompdf();//+
>>>>>>> Tabnine >>>>>>>// {"conversationId":"0b0eafc1-c1ce-47b5-9545-de2446b18375","source":"instruct"}
$html = "
    <h2 style='text-align: center;'>Examination Card</h2>
    <div style='text-align: center;'>
        <img src='../assets/uploads/{$student['photo']}' alt='Student Photo' style='width: 100px; height: 100px; border-radius: 50%;'>
        <h3>{$student['name']}</h3>
        <p>
            <strong>Student ID:</strong> {$student['student_id']}<br>
            <strong>Email:</strong> {$student['email']}<br>
            <strong>Phone:</strong> {$student['phone']}<br>
            <strong>Program:</strong> {$student['program']}
        </p>
        <hr>
        <h4>Registered Courses</h4>
        <ul>";
foreach ($selected_courses as $course) {
    $html .= "<li>{$course}</li>";
}
$html .= "
        </ul>
    </div>
";

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("exam_card.pdf", ["Attachment" => true]);
exit;
