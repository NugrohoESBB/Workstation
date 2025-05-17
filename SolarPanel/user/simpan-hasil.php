<?php
    session_start();
    header('Content-Type: application/json');

    if (!isset($_SESSION['username'])) {
        echo json_encode(['error' => 'Unauthorized']);
        exit;
    }

    $data = json_decode(file_get_contents("php://input"), true);

    $username                   = $_SESSION['username'];
    $lokasi                     = $data['lokasi'];
    $konfigurasi                = $data['konfigurasi'];
    $kebutuhan                  = $data['kebutuhan'];
    $wp                         = $data['wp'];
    $kapasitas_baterai          = $data['kapasitas_baterai'];
    $kapasitas_inverter         = $data['kapasitas_inverter'];

    $jumlah_panel_json          = json_encode($data['jumlah_panel_json'], JSON_UNESCAPED_UNICODE);
    $luas_panel_json            = json_encode($data['luas_panel_json'], JSON_UNESCAPED_UNICODE);
    $jumlah_baterai_json        = json_encode($data['jumlah_baterai_json'], JSON_UNESCAPED_UNICODE);
    $estimasi_harga_panel_json  = json_encode($data['estimasi_harga_panel_json'], JSON_UNESCAPED_UNICODE);
    $jumlah_inverter_json       = json_encode($data['jumlah_inverter_json'], JSON_UNESCAPED_UNICODE);

    $mysqli = new mysqli("localhost", "root", "", "db_solarpanel");
    if ($mysqli->connect_errno) {
        echo json_encode(['error' => 'Gagal koneksi database']);
        exit;
    }

    // Simpan
    $stmt = $mysqli->prepare("INSERT INTO perhitungan 
    (username, lokasi, konfigurasi, kebutuhan, wp, kapasitas_baterai, kapasitas_inverter, jumlah_panel_json, luas_panel_json, jumlah_baterai_json, estimasi_harga_panel_json, jumlah_inverter_json) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssdiidsssss", 
        $username, $lokasi, $konfigurasi, $kebutuhan, $wp, 
        $kapasitas_baterai, $kapasitas_inverter,
        $jumlah_panel_json, $luas_panel_json, $jumlah_baterai_json,
        $estimasi_harga_panel_json, $jumlah_inverter_json
    );

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => $stmt->error]);
    }

    $stmt->close();
    $mysqli->close();
?>