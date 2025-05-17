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
      <a href="?logout=true" class="btn btn-outline-light btn-sm me-2">Logout</a>
      <a href="javascript:void(0);" onclick="redirectToHitungPLN()" class="btn btn-outline-info btn-sm">Hitung PLN</a>
    </div>
  </nav>


  <div class="container py-5">
    <h2 class="mb-4 text-center text-light">Perhitungan Panel Surya</h2>

    <!-- FORM -->
    <div class="card shadow-sm mb-4">
      <div class="card-body">
        <form id="panelForm" class="row g-3">
          <div class="col-md-4">
            <label for="provinsiSelect" class="form-label">Pilih Provinsi</label>
            <select id="provinsiSelect" class="form-select" required>
              <option value="">-- Pilih Provinsi --</option>
            </select>
          </div>
          <div class="col-md-4">
            <label for="lokasiSelect" class="form-label">Pilih Kabupaten/Kota</label>
            <select id="lokasiSelect" class="form-select" required disabled>
              <option value="">-- Pilih Kabupaten/Kota --</option>
            </select>
          </div>

          <div class="col-md-4">
            <label for="konfigurasi" class="form-label">Konfigurasi Panel</label>
            <select id="konfigurasi" class="form-select" required>
              <option value="">-- Pilih Konfigurasi --</option>
              <option value="off-grid">Off-grid</option>
              <option value="hybrid">Hybrid</option>
              <option value="on-grid">On-grid</option>
            </select>
          </div>
          <div class="col-md-4" id="kontribusiPanelGroup">
            <label for="kontribusiPanel" class="form-label">Kontribusi Panel (%)</label>
            <select id="kontribusiPanel" class="form-select">
              <!-- Options in JS -->
            </select>
          </div>

          <div class="col-md-4">
            <label for="kebutuhan" class="form-label">Kebutuhan Energi Harian (kWh)</label>
            <input type="number" class="form-control" id="kebutuhan" step="0.1" min="0.1" required>
          </div>
          <div class="col-12 text-end mt-3">
            <button type="submit" class="btn btn-primary px-4">Hitung</button>
          </div>
        </form>
      </div>
    </div>

    <!-- HASIL PERHITUNGAN -->
    <div id="hasil" class="mb-4"></div>

    <!-- TABLES -->
    <div class="tabelContainer-wrapper tabel-grid mb-4">
      <div id="tabelPanel" class="hidden-table"></div>
      <div id="tabelLuas" class="hidden-table"></div>
    </div>

    <div class="tabelContainer-wrapper tabel-grid mb-4">
      <div id="tabelEstimasiHarga" class="hidden-table"></div>
    </div>

    <div class="tabelContainer-wrapper tabel-grid mb-4">
      <div id="tabelBaterai" class="hidden-table"></div>
      <div id="tabelInverter" class="hidden-table"></div>
    </div>

    <div class="tabelContainer-wrapper tabel-grid mb-4">
      <div id="tabelJumlahBaterai" class="hidden-table"></div>
    </div>

    <div class="tabelContainer-wrapper tabel-grid mb-4">
      <div id="tabelInverterBiaya" class="hidden-table"></div>
    </div>
  </div>

  <!-- JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>

  <script>
    function redirectToHitungPLN() {
      window.location.href = 'hitungpln.php';
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
    // LOCATIONS DATA
    let data = [];
    const provinsiSelect = document.getElementById('provinsiSelect');
    const lokasiSelect = document.getElementById('lokasiSelect');

    fetch('data-irridation.php')
    .then(res => res.json())
    .then(json => {
      data = json;

      const provinsiSet = new Set(json.map(item => item.provinsi));
      provinsiSet.forEach(prov => {
        const option = document.createElement('option');
        option.value = prov;
        option.textContent = prov;
        provinsiSelect.appendChild(option);
      });
    })
    .catch(err => console.error("Gagal ambil data:", err));

    provinsiSelect.addEventListener('change', function () {
      const selectedProvinsi = this.value;
      lokasiSelect.innerHTML = '<option value="">-- Pilih Kabupaten/Kota --</option>';
      lokasiSelect.disabled = true;

      if (selectedProvinsi !== '') {
        const filtered = data.filter(item => item.provinsi === selectedProvinsi);
        filtered.forEach(item => {
          const option = document.createElement('option');
          option.value = item.kab_kota;
          option.textContent = item.kab_kota;
          lokasiSelect.appendChild(option);
        });
        lokasiSelect.disabled = false;
      }
    });


    // OPTION KONFIGURASI PANEL
    const konfigurasiSelect = document.getElementById('konfigurasi');
    const kontribusiPanelGroup = document.getElementById('kontribusiPanelGroup');
    const kontribusiPanelSelect = document.getElementById('kontribusiPanel');

    konfigurasiSelect.addEventListener('change', function () {
      const value = this.value;

      kontribusiPanelSelect.innerHTML = '';
      kontribusiPanelGroup.style.display = 'none';

      if (value === 'off-grid') {
        [100].forEach(p => {
          const opt = document.createElement('option');
          opt.value = p;
          opt.textContent = `${p}%`;
          kontribusiPanelSelect.appendChild(opt);
        });
        kontribusiPanelGroup.style.display = 'block';
      } else if (value === 'on-grid') {
        [40, 50, 60].forEach(p => {
          const opt = document.createElement('option');
          opt.value = p;
          opt.textContent = `${p}%`;
          kontribusiPanelSelect.appendChild(opt);
        });
        kontribusiPanelGroup.style.display = 'block';
      } else if (value === 'hybrid') {
        [60, 70, 80].forEach(p => {
          const opt = document.createElement('option');
          opt.value = p;
          opt.textContent = `${p}%`;
          kontribusiPanelSelect.appendChild(opt);
        });
        kontribusiPanelGroup.style.display = 'block';
      }
    });


    // PERHITUNGAN
    document.getElementById('panelForm').addEventListener('submit', function(e) {
      e.preventDefault();

      const kabKota = document.getElementById('lokasiSelect').value;
      const konfigurasi = document.getElementById('konfigurasi').value;
      const kebutuhan = parseFloat(document.getElementById('kebutuhan').value);

      const lokasi = data.find(item => item.kab_kota === kabKota);


      if (lokasi && kebutuhan && konfigurasi) {
        const irradiasiHarian = Math.round(lokasi.irradiasi_bulanan / 30);
        let efisiensi = 1;
        if (konfigurasi === 'off-grid' || konfigurasi === 'hybrid' || konfigurasi === 'on-grid') {
          const persen = parseInt(kontribusiPanelSelect.value);
          efisiensi = persen / 100;
        }

        const pembagi = irradiasiHarian * 0.66;
        const wp = Math.ceil((kebutuhan * efisiensi / pembagi) * 1000);

        const jenisPanel = ['Poli', 'Mono', 'Bifacial'];
        const wpPanelOptions = [100, 200, 300, 500, 700];
        const luasPanelValues = {
          'Poli': { 100: 0.7324, 200: 1.4701, 300: 1.6269 },
          'Mono': { 100: 0.648, 200: 1.2766, 500: 2.2092, 700: 2.6129 },
          'Bifacial': { 100: 0.715, 200: 1.365, 500: 3.094, 700: 4.368 }
        };

        const bateraiConfigs = [
          { v: 12, ah: 50, harga: 1190000 },
          { v: 12, ah: 100, harga: 1850000 },
          { v: 12, ah: 200, harga: 3595000 },
          { v: 12, ah: 300, harga: 13050000 },
          { v: 24, ah: 100, harga: 2688000 },
          { v: 48, ah: 200, harga: 7562000 },
        ];

        const estimasiHargaPanelValues = {
          'Poli': { 100: 1450000, 200: 3000000, 300: 4350000 },
          'Mono': { 100: 700000, 200: 1400000, 500: 2355000, 700: 3898000 },
          'Bifacial': { 100: 2200000, 200: 3800000, 500: 7500000, 700: 10500000 }
        };

        const kapasitasPilihan = [1.5, 2, 3, 7];
        const hargaPerUnit = { 1.5: 1550000, 2: 2800000, 3: 4900000, 7: 10000000 };

        function hitungJumlahPanel(jenis, wpPanel) {
          const excluded = (jenis === 'Poli' && (wpPanel === 500 || wpPanel === 700)) ||
          (jenis === 'Mono' && wpPanel === 300) ||
          (jenis === 'Bifacial' && wpPanel === 300);
          if (excluded) return 'X';
          const faktor = jenis === 'Poli' ? 0.8 : jenis === 'Mono' ? 1 : 1.2;
          return Math.ceil(wp / (wpPanel * faktor));
        }

        function hitungLuasPanel(jenis, wpPanel) {
          const jumlah = hitungJumlahPanel(jenis, wpPanel);
          const luas = luasPanelValues[jenis]?.[wpPanel];
          if (jumlah === 'X' || !luas) return 'X';
          return (jumlah * luas).toFixed(2) + ' m²';
        }

        function hitungEstimasiHargaPanel(jenis, wpPanel) {
          const jumlah = hitungJumlahPanel(jenis, wpPanel);
          const luas = estimasiHargaPanelValues[jenis]?.[wpPanel];
          if (jumlah === 'X' || !luas) return 'X';
          return 'Rp. ' + (jumlah * luas).toLocaleString('id-ID');
        }

        // Buat data JSON
        const jumlahPanelRows = jenisPanel.map(jenis => [jenis, ...wpPanelOptions.map(wp => hitungJumlahPanel(jenis, wp))]);
        const luasPanelRows = jenisPanel.map(jenis => [jenis, ...wpPanelOptions.map(wp => hitungLuasPanel(jenis, wp))]);
        const estimasiHargaPanelRows = jenisPanel.map(jenis => [jenis, ...wpPanelOptions.map(wp => hitungEstimasiHargaPanel(jenis, wp))]);

        const kapasitas_baterai = Math.ceil((wp / 0.95) * 2);
        const voltOptions = [12, 24, 48];
        const ahOptions = [50, 100, 200, 300, 500];
        const jumlahBateraiRows = bateraiConfigs.map(cfg => {
          const jumlah = Math.ceil(kapasitas_baterai / (cfg.v * cfg.ah));
          const estimasi = jumlah * cfg.harga;
          return [cfg.v, cfg.ah, jumlah, 'Rp. ' + estimasi.toLocaleString('id-ID')];
        });

        const kapasitas_inverter = Math.ceil((wp * 2) / 1000);

        const inverterRows = kapasitasPilihan.map(kapasitas => {
          const jumlah = Math.ceil(kapasitas_inverter / kapasitas);
          const estimasi = jumlah * hargaPerUnit[kapasitas];
          return [`${kapasitas} kW`, jumlah, `Rp. ${estimasi.toLocaleString('id-ID')}`];
        });

        // SIMPAN KE DATABASE
        fetch('simpan-hasil.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({
            lokasi: kabKota,
            konfigurasi,
            kebutuhan,
            wp,
            kapasitas_baterai,
            kapasitas_inverter,
            jumlah_panel_json: jumlahPanelRows,
            luas_panel_json: luasPanelRows,
            jumlah_baterai_json: jumlahBateraiRows,
            estimasi_harga_panel_json: estimasiHargaPanelRows,
            jumlah_inverter_json: inverterRows
          })
        })
        .then(res => res.json())
        .then(res => {
          if (res.success) {
            console.log("✅ Data perhitungan berhasil disimpan.");
          } else {
            console.error("❌ Gagal simpan data:", res.error);
          }
        });

        // Tampilkan ke user
        document.getElementById('hasil').innerHTML = `
          <div class="alert alert-secondary shadow-sm">
            <h5 class="mb-2">Hasil Perhitungan:</h5>
            <ul class="mb-0">
              <li><strong>Irradiasi Bulanan:</strong> ${lokasi.irradiasi_bulanan} kWh/m²</li>
              <li><strong>Irradiasi Harian:</strong> ${irradiasiHarian} kWh/m²</li>
              <li><strong>Orientasi:</strong> ${lokasi.orientasi || '-'}</li>
              <li><strong>Kemiringan:</strong> ${lokasi.kemiringan || '-'}</li>
              <li><strong>Kapasitas Panel yang Dibutuhkan:</strong> <u>${wp} WP</u></li>
            </ul>
          </div>
        `;

        function buatTabel(id, title, headers, dataRows) {
          let html = `<div class="card shadow-sm">
          <div class="card-header bg-secondary text-white"><strong>${title}</strong></div>
          <div class="card-body p-0">
            <table class="table table-bordered table-hover mb-0">
          <thead><tr><th>${headers[0]}</th>`;
          headers.slice(1).forEach(h => html += `<th>${h}</th>`);
          html += '</tr></thead><tbody>';

          dataRows.forEach(row => {
            html += `<tr><td><strong>${row[0]}</strong></td>`;
            row.slice(1).forEach(cell => {
              const isX = cell === 'X';
              html += `<td${isX ? ' class="cell-x"' : ''}>${cell}</td>`;
            });
            html += '</tr>';
          });

          html += '</tbody></table></div></div>';

          const el = document.getElementById(id);
          el.innerHTML = html;
          el.classList.remove('hidden-table');
        }

        buatTabel('tabelPanel', 'Jumlah Panel', ['Jenis \\ WP', ...wpPanelOptions], jumlahPanelRows);
        buatTabel('tabelLuas', 'Luas Panel', ['Jenis \\ WP', ...wpPanelOptions], luasPanelRows);
        buatTabel('tabelEstimasiHarga', 'Estimasi Harga Panel', ['Jenis \\ WP', ...wpPanelOptions], estimasiHargaPanelRows);

        if (konfigurasi !== 'on-grid') {
          buatTabel('tabelJumlahBaterai', 'Jumlah dan Estimasi Biaya Baterai', ['V', 'Ah', 'Jumlah', 'Estimasi Biaya'], jumlahBateraiRows);
          buatTabel('tabelBaterai', 'Kapasitas Baterai', ['Kapasitas (Wh)'], [[kapasitas_baterai]]);
          buatTabel('tabelInverter', 'Kapasitas Inverter', ['Kapasitas (kWh)'], [[kapasitas_inverter]]);
          buatTabel('tabelInverterBiaya', 'Jumlah dan Estimasi Biaya Inverter', ['kW', 'Jumlah', 'Estimasi Biaya'], inverterRows);
        } else {
          document.getElementById('tabelJumlahBaterai').classList.add('hidden-table');
          document.getElementById('tabelBaterai').classList.add('hidden-table');
          document.getElementById('tabelInverter').classList.add('hidden-table');
          document.getElementById('tabelInverterBiaya').classList.add('hidden-table');
        }

      }
    });
  </script>

  
</body>
</html>
