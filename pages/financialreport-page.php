<?php
require '../config/config.php';
session_start();

// Periksa akses
if ($_SESSION["role"] !== 'admin') {
    echo "<script>alert('Access denied.');</script>";
    header("Location: ../pages/dashboard-page.php");
    exit;
}

// Ambil filter dari query string jika ada
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'daily';
$startDate = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-d');
$endDate = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-d');

// Filter berdasarkan waktu
switch ($filter) {
    case 'daily':
        $dateFilter = "DATE(created_at) = DATE('$startDate')";
        break;
    case 'weekly':
        $dateFilter = "YEARWEEK(created_at, 1) = YEARWEEK('$startDate', 1)";
        break;
    case 'monthly':
        $dateFilter = "MONTH(created_at) = MONTH('$startDate') AND YEAR(created_at) = YEAR('$startDate')";
        break;
    case 'yearly':
        $dateFilter = "YEAR(created_at) = YEAR('$startDate')";
        break;
    default:
        $dateFilter = "DATE(created_at) = DATE('$startDate')";
        break;
}

// Query untuk transaksi
$transaction_query = "SELECT * FROM transactions WHERE $dateFilter";
$transaction_result = mysqli_query($conn, $transaction_query);

// Query untuk stok barang
$stock_query = "SELECT p.product_name, s.quantity, s.log_date, s.action
                FROM stock_logs s
                JOIN products p ON s.product_id = p.product_id
                WHERE DATE(s.log_date) BETWEEN DATE('$startDate') AND DATE('$endDate')";
$stock_result = mysqli_query($conn, $stock_query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Financial Report</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Financial Report</h2>

        <!-- Form filter -->
        <form method="GET" action="">
            <label for="filter">Filter:</label>
            <select name="filter" id="filter">
                <option value="daily" <?= $filter === 'daily' ? 'selected' : '' ?>>Daily</option>
                <option value="weekly" <?= $filter === 'weekly' ? 'selected' : '' ?>>Weekly</option>
                <option value="monthly" <?= $filter === 'monthly' ? 'selected' : '' ?>>Monthly</option>
                <option value="yearly" <?= $filter === 'yearly' ? 'selected' : '' ?>>Yearly</option>
            </select>
            <label for="start_date">Start Date:</label>
            <input type="date" id="start_date" name="start_date" value="<?= $startDate ?>">
            <label for="end_date">End Date:</label>
            <input type="date" id="end_date" name="end_date" value="<?= $endDate ?>">
            <button type="submit">Filter</button>
        </form>

        <h3>Transactions</h3>
        <table>
            <thead>
                <tr>
                    <th>Transaction ID</th>
                    <th>User ID</th>
                    <th>Total</th>
                    <th>Created At</th>
                    <th>Customer ID</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($transaction = mysqli_fetch_assoc($transaction_result)): ?>
                    <tr>
                        <td><?= $transaction['transactions_id'] ?></td>
                        <td><?= $transaction['user_id'] ?></td>
                        <td><?= number_format($transaction['total'], 2) ?></td>
                        <td><?= $transaction['created_at'] ?></td>
                        <td><?= $transaction['customer_id'] ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <h3>Stock Logs</h3>
        <table>
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Log Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($stock = mysqli_fetch_assoc($stock_result)): ?>
                    <tr>
                        <td><?= $stock['product_name'] ?></td>
                        <td><?= $stock['quantity'] ?></td>
                        <td><?= $stock['log_date'] ?></td>
                        <td><?= $stock['action'] ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <?php
        // Hitung keuntungan
        $profit_query = "SELECT SUM(total) AS total_revenue
                            FROM transactions
                            WHERE $dateFilter";
        $profit_result = mysqli_query($conn, $profit_query);
        $total_revenue = mysqli_fetch_assoc($profit_result)['total_revenue'];

        $cost_query = "SELECT SUM(quantity * price) AS total_cost
                        FROM transaction_items
                        WHERE EXISTS (SELECT 1 FROM transactions WHERE transactions_id = transaction_items.transaction_id AND $dateFilter)";
        $cost_result = mysqli_query($conn, $cost_query);
        $total_cost = mysqli_fetch_assoc($cost_result)['total_cost'];

        $profit = $total_revenue - $total_cost;
        ?>

        <h3>Profit Calculation</h3>
        <p>Total Revenue: <?= number_format($total_revenue, 2) ?></p>
        <p>Total Cost: <?= number_format($total_cost, 2) ?></p>
        <p>Profit: <?= number_format($profit, 2) ?></p>
    </div>
</body>
</html>
