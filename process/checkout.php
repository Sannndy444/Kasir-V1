<?php
require '../config/config.php';
session_start();
ob_start();

// Aktifkan penanganan error
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$data = json_decode(file_get_contents("php://input"), true);
$transactionItems = $data['transactionItems'];
$customerName = $data['customerName'];

if (!isset($_SESSION['users_id'])) {
    echo json_encode(['success' => false, 'message' => 'User ID is missing.']);
    ob_end_flush();
    exit;
}

$userId = $_SESSION['users_id'];

// Mulai transaksi
$conn->begin_transaction();

try {
    // Periksa apakah customer sudah ada
    $query = "SELECT customer_id FROM customers WHERE customer_name = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $customerName);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Jika customer ada, ambil ID customer
        $stmt->bind_result($customerId);
        $stmt->fetch();
    } else {
        // Jika customer tidak ada, tambah customer baru
        $query = "INSERT INTO customers (customer_name, created_at) VALUES (?, NOW())";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $customerName);
        $stmt->execute();
        $customerId = $stmt->insert_id; // Ambil ID customer yang baru dibuat
    }

    // Cek stok produk sebelum menyimpan transaksi
    foreach ($transactionItems as $item) {
        $query = "SELECT stock FROM products WHERE product_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $item['id']);
        $stmt->execute();
        $stmt->bind_result($stock);
        $stmt->fetch();

        // Jika stok tidak mencukupi
        if ($stock < $item['quantity']) {
            throw new Exception('Stock for product ' . $item['name'] . ' is insufficient.');
        }

        // Tutup statement
        $stmt->close();
    }

    // Insert transaksi
    $total = array_reduce($transactionItems, function($sum, $item) {
        return $sum + $item['totalPrice'];
    }, 0);

    $query = "INSERT INTO transactions (user_id, total, created_at, customer_id) VALUES (?, ?, NOW(), ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('idi', $userId, $total, $customerId);
    $stmt->execute();
    $transactionId = $stmt->insert_id; // Ambil ID transaksi yang baru dibuat

    // Insert item transaksi dan update stok produk
    foreach ($transactionItems as $item) {
        $query = "INSERT INTO transaction_items (transaction_id, product_id, quantity, price, subtotal) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('iiidd', $transactionId, $item['id'], $item['quantity'], $item['price'], $item['totalPrice']);
        $stmt->execute();

        // Kurangi stok produk
        $query = "UPDATE products SET stock = stock - ? WHERE product_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ii', $item['quantity'], $item['id']);
        $stmt->execute();

        // Tutup statement
        $stmt->close();
    }

    // Commit transaksi
    $conn->commit();
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    // Rollback jika terjadi kesalahan
    $conn->rollback();
    error_log('Error: ' . $e->getMessage()); // Log kesalahan
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

ob_end_flush();