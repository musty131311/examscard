<?php
include '../includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['student_num'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $program = $_POST['program'];
    $selected_courses = isset($_POST['courses']) ? implode(',', $_POST['courses']) : ''; // Combine selected course IDs
    $photo = $_FILES['photo'];

    // File upload handling
    $targetDir = "../assets/uploads/";
    $targetFile = $targetDir . basename($photo['name']);
    move_uploaded_file($photo['tmp_name'], $targetFile);

    try {
        $stmt = $pdo->prepare("INSERT INTO students (student_num, name, email, phone, password, program, course_ids, photo) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$student_id, $name, $email, $phone, $password, $program, $selected_courses, $targetFile]);
        echo "<div class='alert alert-success text-center'>Registration successful!</div>";
    } catch (PDOException $e) {
        echo "<div class='alert alert-danger text-center'>Error: " . $e->getMessage() . "</div>";
    }
}

// Fetch available courses
$courses = [];
try {
    $courses_stmt = $pdo->query("SELECT exam_id, course_code, course_name FROM examinations");
    $courses = $courses_stmt->fetchAll();
} catch (PDOException $e) {
    echo "<div class='alert alert-danger text-center'>Error fetching courses: " . $e->getMessage() . "</div>";
}
?>

<?php include '../includes/header.php'; ?>
<div class="container mt-5">
    <h2 class="text-center mb-4">Student Registration</h2>
    <form action="" method="POST" enctype="multipart/form-data" class="mx-auto" style="max-width: 600px;">
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="student_id" class="form-label">Student ID</label>
                    <input type="text" name="student_id" id="student_num" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" id="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="tel" name="phone" id="phone" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="program" class="form-label">Program</label>
                    <select name="program" id="program" class="form-select" required>
                        <option value="" disabled selected>Select Program</option>
                        <option value="Nursing">Nursing</option>
                        <option value="Midwifery">Midwifery</option>
                        <option value="Public Health">Public Health</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="courses" class="form-label">Courses</label>
                    <div>
                        <?php if (!empty($courses)): ?>
                            <?php foreach ($courses as $course): ?>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="courses[]" value="<?= $course['exam_id']; ?>">
                                    <label class="form-check-label"><?= htmlspecialchars($course['course_code']); ?> - <?= htmlspecialchars($course['course_name']); ?></label>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="text-danger">No courses available at the moment.</p>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="photo" class="form-label">Photo</label>
                    <input type="file" name="photo" id="photo" class="form-control" accept="image/*" onchange="previewImage(event)">
                    <div class="mt-2">
                        <img id="preview" src="#" alt="Photo Preview" class="img-thumbnail" style="display: none; max-width: 150px;">
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-primary w-100">Register</button>
        </div>
    </form>
</div>
<script>
function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function () {
        document.getElementById('preview').src = reader.result;
        document.getElementById('preview').style.display = 'block';
    };
    reader.readAsDataURL(event.target.files[0]);
}
</script>
<?php include '../includes/footer.php'; ?>
