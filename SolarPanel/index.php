<?php
    session_start();
    
    $host = 'localhost';
    $user = 'root';
    $pass = '';
    $db   = 'db_solarpanel';

    $conn = new mysqli($host, $user, $pass, $db);
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    $message = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST["n"];
        $password = $_POST["p"];

        $stmt = $conn->prepare("SELECT * FROM data_user WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();

            if (password_verify($password, $row["password"])) {
                $_SESSION["username"] = $row["username"];
                $_SESSION["role"] = $row["role"];

                if ($row["role"] === "admin") {
                    header("Location: admin/index.php");
                    exit;
                } else if ($row["role"] === "user") {
                    header("Location: user/index.php");
                    exit;
                } else {
                    $message = "<span style='color:red;'>Role tidak dikenali.</span>";
                }
            } else {
                $message = "<span style='color:red;'>Password salah!</span>";
            }
        } else {
            $message = "<span style='color:red;'>Username tidak ditemukan!</span>";
        }

        $stmt->close();
        $conn->close();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link rel="icon" type="image/png" href="assets/data/images/icons/favicon.ico"/>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- Custom styles -->
    <link href="assets/data/css/style.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
</head>

<body>
    <div id="particles-js"></div>
    <form class="login-form" id="loginForm" method="POST">
        <h1 class="login-title">Login</h1>
        <?php
            if (!empty($message)) { 
                echo "<div style='margin-bottom: 10px;'>$message</div>";
            } 
        ?>
        <div class="input-box">
            <i class='bx bxs-user'></i>
            <input type="text" id="n" name="n" placeholder="Username" required>
        </div>
        <div class="input-box">
            <i class='bx bxs-lock-alt'></i>
            <input type="password" id="p" name="p" placeholder="Password" required>
        </div>
        <button type="submit" class="login-btn">Login</button>
        <p class="register">Don't have an account? <a href="#" onclick="gotoRegis()">Register</a></p>
    </form>

    <script>
        function gotoRegis() {
            window.location.href = "inputUsers.php";
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
