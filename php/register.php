<?php

require_once "config.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $fullName = $_POST['fullname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE username = :username OR email = :email");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        $message = "Username or email already exists.";
        $messageType = "Error";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (full_name, username, email, password) VALUES (:full_name, :username, :email, :password)");
        $stmt->bindParam(':full_name', $fullName);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);

        if ($stmt->execute()) {
            $message = "Data inserted successfully.";
            $messageType = "success";
        } else {
            $message = "Data insertion failed.";
            $messageType = "Error";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-light">
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card shadow p-4" style="width: 100%; max-width: 400px;">
            <h3 class="text-center text-primary">Register</h3>
            <p class="text-center text-muted">Daftar untuk membuat akun baru</p>
            <form action="" method="POST">
                <div class="mb-3">
                    <label for="fullname" class="form-label">Nama Lengkap</label>
                    <input type="text" id="fullname" name="fullname" class="form-control" placeholder="Masukkan nama lengkap" required>
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" id="username" name="username" class="form-control" placeholder="Masukkan username" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="Masukkan email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Register</button>
            </form>
            <div class="text-center mt-3">
                <p class="text-muted">Sudah punya akun? <a href="login.php" class="text-primary">Login</a></p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            <?php if (!empty($message)) : ?>
                Swal.fire({
                    icon: '<?= $messageType ?>',
                    title: '<?= $messageType === "success" ? "Success" : "Error" ?>',
                    text: '<?= $message ?>',
                    confirmButtonText: 'OK'
                });
            <?php endif; ?>
        });
    </script>
</body>

</html>