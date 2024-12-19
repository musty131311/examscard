<?php
include '../includes/db_connect.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// Fetch all issued exam cards
$stmt = $pdo->query("SELECT e.card_id, s.name, s.phone, s.program, e.course, e.exam_date, e.exam_venue, e.issued_at
                     FROM exam_cards e
                     JOIN students s ON e.student_id = s.student_id");
$cards = $stmt->fetchAll();
?>

<?php include '../includes/header.php'; ?>
<div class="container">
    <h2 class="text-center my-4">Examination Cards Report</h2>
    <?php if (count($cards) > 0): ?>
        <table class="table table-bordered table-striped">
            <thead class="table-primary">
                <tr>
                    <th>Card ID</th>
                    <th>Student Name</th>
                    <th>Phone</th>
                    <th>Program</th>
                    <th>Course</th>
                    <th>Exam Date</th>
                    <th>Venue</th>
                    <th>Issued At</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cards as $card): ?>
                <tr>
                    <td><?= $card['card_id']; ?></td>
                    <td><?= htmlspecialchars($card['name']); ?></td>
                    <td><?= htmlspecialchars($card['phone']); ?></td>
                    <td><?= htmlspecialchars($card['program']); ?></td>
                    <td><?= htmlspecialchars($card['course']); ?></td>
                    <td><?= htmlspecialchars($card['exam_date']); ?></td>
                    <td><?= htmlspecialchars($card['exam_venue']); ?></td>
                    <td><?= htmlspecialchars($card['issued_at']); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-warning text-center">No examination cards have been issued yet.</div>
    <?php endif; ?>
</div>
