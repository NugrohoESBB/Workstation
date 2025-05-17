<?php
  header('Content-Type: application/json');

  $host = 'localhost';
  $user = 'root';
  $pass = '';
  $db   = 'db_solarpanel';

  $conn = new mysqli($host, $user, $pass, $db);

  if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['error' => 'Gagal koneksi database: ' . $conn->connect_error]);
    exit;
  }

  $sql = "SELECT provinsi, kab_kota, irradiasi_bulanan, orientasi, kemiringan FROM data_irradiasi ORDER BY provinsi";
  $result = $conn->query($sql);

  $data = [];
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $row['kemiringan'] = $row['kemiringan'] !== null ? floatval($row['kemiringan']) : null;
      $row['irradiasi_bulanan'] = floatval($row['irradiasi_bulanan']);
      $data[] = $row;
    }
  }

  echo json_encode($data);

  $conn->close();
?>
