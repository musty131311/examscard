<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Jigawa State College of Nursing and Midwifery</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header class="bg-primary text-white py-4">
        <div class="container d-flex align-items-center justify-content-between">
            <img src="assets/uploads/logo.png" alt="College Logo" style="width: 80px; height: 80px;">
            <h1 class="mb-0">Jigawa State College of Nursing and Midwifery</h1>
        </div>
    </header>

    <main class="container mt-5">
        <div class="text-center">
            <h2>Welcome to the Examination Management System</h2>
            <p class="lead text-muted">Streamlining the process of managing examinations for students and administrators.</p>
        </div>

        <!-- Your Name and Registration Number -->
        <div class="text-center mt-4">
            <h5>Developed By:</h5>
            <p class="fw-bold">Zubairu Bakiru Wabi</p>
            <p>Registration Number: NDC/2022/919</p>
        </div>

        <div class="row mt-5">
            <div class="col-md-6 text-center">
                <div class="card shadow">
                    <div class="card-body">
                        <h4 class="card-title">Students</h4>
                        <p class="card-text">Register for your examinations, view exam details, and generate your examination card.</p>
                        <a href="students/register.php" class="btn btn-primary">Register Now</a>
                        <a href="students/login.php" class="btn btn-success">Login</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 text-center">
                <div class="card shadow">
                    <div class="card-body">
                        <h4 class="card-title">Administrators</h4>
                        <p class="card-text">Manage student registrations, courses, and examination details with ease.</p>
                        <a href="admin/login.php" class="btn btn-primary">Admin Login</a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="bg-dark text-white text-center py-3 mt-5">
        <p>© <?= date('Y'); ?> Jigawa State College of Nursing and Midwifery. All Rights Reserved.</p>
        <p>Contact Us: <a href="mailto:info@jigawacnm.edu.ng" class="text-white">info@jigawacnm.edu.ng</a> | Phone: +234 800 123 4567</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
