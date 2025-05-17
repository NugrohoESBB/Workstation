<?php
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db   = "db_solarpanel";

    $conn = new mysqli($host, $user, $pass, $db);
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST["n"];
        $email    = $_POST["e"];
        $password = $_POST["p"];
        $role     = $_POST["r"];

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $check = $conn->prepare("SELECT * FROM data_user WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $result = $check->get_result();

        if ($result->num_rows > 0) {
            echo "<script>alert('Email sudah terdaftar!');</script>";
        } else {
            $stmt = $conn->prepare("INSERT INTO data_user (username, email, password, role) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $username, $email, $hashedPassword, $role);

            if ($stmt->execute()) {
                $message = "<span style='color: green;'>Register berhasil! Silakan login.</span>";
            } else {
                $message = "<span style='color: red;'>Gagal mendaftar. Silakan coba lagi.</span>";
            }

            $stmt->close();
        }

        $check->close();
        $conn->close();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <link rel="icon" type="image/png" href="assets/data/images/icons/favicon.ico"/>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- Custom styles -->
    <link href="assets/data/css/style.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
</head>

<body>
    <div id="particles-js"></div>
    <form action="" method="POST" class="login-form" id="loginForm">
        <h1 class="login-title">Register</h1>
        <div class="input-box">
            <i class='bx bxs-user'></i>
            <input type="text" id="n" name="n" class="form-control" placeholder="Username" required>
        </div>
        <div class="input-box">
            <i class='bx bxs-envelope'></i>
            <input type="email" id="e" name="e" class="form-control" placeholder="Email" required>
        </div>
        <div class="input-box">
            <i class='bx bxs-lock-alt'></i>
            <input type="password" id="p" name="p" class="form-control" placeholder="Password" required>
        </div>
        <div class="input-box">
            <i class='bx bxs-user-circle'></i>
            <select id="r" name="r" required>
                <option value="" disabled selected>Role</option>
                <option value="user">User</option>
            </select>
        </div>
        <button type="submit" class="login-btn">Register</button>
        <p class="register">Already have an account? <a href="#" onclick="gotoLogin()">Login</a></p>
    </form>

    <script type="text/javascript">
        function gotoLogin() {
          window.location.href = "index.php";
        }
    </script>

    <script>
        particlesJS("particles-js", {
            "particles": {
                "number": { "value": 80, "density": { "enable": true, "value_area": 800 } },
                "color": { "value": "#ffffff" },
                "shape": { "type": "circle" },
                "opacity": { "value": 0.5, "random": false },
                "size": { "value": 3, "random": true },
                "line_linked": { "enable": true, "distance": 150, "color": "#ffffff", "opacity": 0.4, "width": 1 },
                "move": { "enable": true, "speed": 6, "direction": "none", "random": false, "straight": false }
            },
            "interactivity": {
                "detect_on": "canvas",
                "events": { "onhover": { "enable": true, "mode": "repulse" }, "onclick": { "enable": true, "mode": "push" } }
            },
            "retina_detect": true
        });
    </script>


</body>
</html>
