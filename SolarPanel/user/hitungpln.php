<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'user') {
  header("Location: ../index.php");
  exit();
}

$username = $_SESSION['username'];
$role = $_SESSION['role'];

$current_time = date('Ymd-His');

$cookie_name = $role . '-' . $current_time;

setcookie('custom_session', $cookie_name, time() + (30 * 24 * 60 * 60), '/');

if (isset($_GET['logout']) && $_GET['logout'] === 'true') {
  session_unset();
  session_destroy();

  if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
      $params["path"], $params["domain"],
      $params["secure"], $params["httponly"]
    );
  }

  setcookie('custom_session', '', time() - 3600, '/');

  header("Location: ../index.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Solar Panel</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <link href="assets/img/favicon.png" rel="icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #1f1f1f);
      color: #f1f1f1;
      position: relative;
      overflow-x: hidden;
    }

    #particles-js {
      position: fixed;
      width: 100%;
      height: 100%;
      z-index: -1;
      top: 0;
      left: 0;
    }

    .container {
      position: relative;
      z-index: 1;
      max-width: 700px; /* Tambahkan ini */
      margin: 0 auto;   /* Tambahkan ini */
    }


    .card {
      background: rgba(255, 255, 255, 0.05);
      backdrop-filter: blur(15px);
      -webkit-backdrop-filter: blur(15px);
      border-radius: 20px;
      border: 1px solid rgba(255, 255, 255, 0.1);
      box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
      color: #ffffff;
      transition: all 0.3s ease;
    }

    .card:hover {
      box-shadow: 0 10px 40px rgba(255, 255, 255, 0.1);
      transform: translateY(-5px);
    }

    .card.glass {
      background: rgba(255, 255, 255, 0.05);
      border: 1px solid rgba(255, 255, 255, 0.15);
      border-radius: 15px;
      backdrop-filter: blur(15px);
      box-shadow: 0 8px 24px rgba(0,0,0,0.4);
    }

    form .form-label {
      font-size: 0.8rem;
      color: #e0e0e0;
    }

    form .form-select,
    form .form-control {
      font-size: 0.85rem;
      padding: 0.4rem 0.7rem;
      border-radius: 8px;
      background-color: rgba(255,255,255,0.08);
      border: 1px solid rgba(255,255,255,0.15);
      color: white;
    }

    form .btn {
      font-size: 0.9rem;
      padding: 0.4rem 1.2rem;
      border-radius: 12px;
    }

    .card-body {
      padding: 1.5rem;
    }

    form .row {
      gap: 1rem;
    }

    select.form-select, 
    input.form-control {
      color: #ffffff;
      background-color: rgba(255, 255, 255, 0.05);
      border: 1px solid rgba(255, 255, 255, 0.15);
    }

    select.form-select option {
      color: #000;
      background-color: #fff;
    }

    .btn-primary {
      background-color: #00bcd4;
      border: none;
      color: #fff;
      font-weight: 500;
      padding: 0.5rem 1.5rem;
      border-radius: 8px;
      transition: background-color 0.3s ease, transform 0.2s ease;
      box-shadow: 0 4px 10px rgba(0, 188, 212, 0.3);
    }

    .btn-primary:hover {
      background-color: #00acc1;
      transform: translateY(-1px);
      box-shadow: 0 6px 15px rgba(0, 188, 212, 0.5);
    }


    h2 {
      font-weight: 600;
      color: #444;
    }

    label {
      font-weight: 500;
      color: #555;
    }

    .form-control, .form-select {
      border-radius: 10px;
      border: 1px solid #dcdcdc;
    }

    .hidden-table { display: none; }
    .table th, .table td { vertical-align: middle; text-align: center; }
    .tabel-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem; }
    .cell-x { background-color: #f8d7da !important; color: #842029 !important; font-weight: bold; }

    .position-absolute a.btn {
      margin-left: 10px;
    }
  </style>
</head>
<body>
  <div id="particles-js"></div>

  <nav class="navbar navbar-dark bg-transparent px-4 py-2 d-flex justify-content-between align-items-center">
    <h5 class="text-white m-0">Solar Panel</h5>
    <div>
      <a href="javascript:void(0);" onclick="redirectToHitungPanel()" class="btn btn-outline-info btn-sm">Hitung Panel</a>
    </div>
  </nav>


  <div class="container py-5">
    <h2 class="mb-4 text-center text-light">Perhitungan PLN</h2>

    <!-- FORM -->
    <div class="card shadow-sm mb-4 mx-auto">
      <div class="card-body">
        <form id="plnForm" class="mb-2">
          <div class="row">
            <div class="md-4">
              <label for="biayaPln" class="form-label">Biaya PLN Bulanan (Rp)</label>
              <input type="number" id="biayaPln" class="form-control" placeholder="Contoh: 300000">
            </div>
          </div>
          <button type="submit" class="btn btn-primary mt-3">Hitung kWh PLN</button>
        </form>
      </div>
    </div>

    <!-- HASIL PERHITUNGAN -->
    <div id="hasilPln" class="mb-4"></div>

  </div>

  <!-- JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>

  <script>
    function redirectToHitungPanel() {
      window.location.href = 'index.php';
    }

    particlesJS('particles-js', {
      "particles": {
        "number": { "value": 50 },
        "color": { "value": "#ffffff" },
        "shape": { "type": "circle" },
        "opacity": {
          "value": 0.5,
          "random": true
        },
        "size": {
          "value": 6,
          "random": true
        },
        "line_linked": {
          "enable": true,
          "distance": 120,
          "color": "#b2dfdb",
          "opacity": 0.4,
          "width": 1
        },
        "move": {
          "enable": true,
          "speed": 2
        }
      },
      "interactivity": {
        "detect_on": "canvas",
        "events": {
          "onhover": { "enable": true, "mode": "repulse" },
          "onclick": { "enable": true, "mode": "push" }
        },
        "modes": {
          "repulse": { "distance": 100 },
          "push": { "particles_nb": 4 }
        }
      },
      "retina_detect": true
    });
  </script>

  <script>
    // PERHITUNGAN
    document.getElementById('plnForm').addEventListener('submit', function(e) {
      e.preventDefault();

      const biaya = parseFloat(document.getElementById('biayaPln').value);
      const hasilEl = document.getElementById('hasilPln');

      if (!biaya) {
        hasilEl.innerHTML = `<div class="alert alert-warning">Mohon isi biaya PLN bulanan.</div>`;
        return;
      }

      const tarifPerVA = {
        '450': 415,
        '900': 605,
        '1300': 1444.7,
        '2200': 1699.5
      };

      const perhitunganKwh = (tarif) => (biaya / (30 * tarif)).toFixed(2);

      const dataTable = [
        { va: '450 VA (Subsidi)', tarif: tarifPerVA['450'], kwh: perhitunganKwh(tarifPerVA['450']) },
        { va: '900 VA (Subsidi)', tarif: tarifPerVA['900'], kwh: perhitunganKwh(tarifPerVA['900']) },
        { va: '900 VA (Non-Subsidi)', tarif: tarifPerVA['900'], kwh: perhitunganKwh(tarifPerVA['900']) },
        { va: '1300 VA', tarif: tarifPerVA['1300'], kwh: perhitunganKwh(tarifPerVA['1300']) },
        { va: '>2200 VA', tarif: tarifPerVA['2200'], kwh: perhitunganKwh(tarifPerVA['2200']) }
      ];

      let tableHtml = `
      <div class="card shadow-sm">
        <div class="card-header bg-secondary text-white"><strong>Hasil Perhitungan Pemakaian PLN</strong></div>
        <div class="card-body p-0">
          <table class="table table-bordered table-hover mb-0">
            <thead>
              <tr>
                <th>VA</th>
                <th>Rp</th>
                <th>kWh</th>
              </tr>
            </thead>
            <tbody>
      `;

      dataTable.forEach(row => {
        tableHtml += `
        <tr>
          <td>${row.va}</td>
          <td>Rp ${biaya.toLocaleString('id-ID')}</td>
          <td>${row.kwh} kWh</td>
        </tr>
        `;
      });

      tableHtml += `
            </tbody>
          </table>
        </div>
      </div>
      `;

      hasilEl.innerHTML = tableHtml;
    });
  </script>

  
</body>
</html>
