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

    <!-- My style -->
    <!-- <link rel="stylesheet" href="../css/styles.css"> -->
    <style>
        :root {
            --primary: #E3E1D9;
            --bg: #F2EFE5;
            --third: #C7C8CC;
            --nav: #495464;
            --font: #424242;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins';
            min-height: 2000px;
            color: #fff;
            background-color: var(--bg);
            overflow-x: hidden;
        }

        .container {
            display: flex;
            min-height: 100vh;
            margin-left: 60px;
        }

        .content {
            padding: 20px;
            flex-grow: 1;
        }

        .judul h2 {
            color: #5a5a5a;
            margin-bottom: 20px;
        }

        .report-form {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        form {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            color: var(--font);
        }

        input, select, .filter {
            padding: 8px 12px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: calc(33% - 20px);
        }

        button {
            background-color: #28a745;
            color: var(--primary);
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #218838;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: var(--nav);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            overflow: hidden;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            color: var(--font);
            text-align: left;
        }

        th {
            background-color: #f7f7f7;
            font-weight: bold;
            color: var(--font);
        }

        td {
            background-color: var(--primary);
        }

        h3 {
            color: var(--font);
            margin-top: 30px;
            margin-bottom: 15px;
        }

        p {
            font-size: 18px;
            margin-bottom: 5px;
            color: var(--font);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <?php include 'sidebar.php'; ?> 
        </div>
        <div class="content">
            <div class="judul">
                <h2>Financial Report</h2>
            </div>
            <hr>
            <div class="report-form">
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
                    <button class="filter" type="submit">Filter</button>
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

                <?php
                // Hitung keuntungan
                // Menghitung total revenue (total pendapatan dari transaksi berdasarkan subtotal di transaction_items)
                    $profit_query = "SELECT SUM(subtotal) AS total_revenue
                    FROM transaction_items
                    WHERE EXISTS (
                        SELECT 1 FROM transactions 
                        WHERE transactions.transactions_id = transaction_items.transaction_id 
                        AND $dateFilter
                    )";
                    $profit_result = mysqli_query($conn, $profit_query);
                    $total_revenue = mysqli_fetch_assoc($profit_result)['total_revenue'];

                    // Menghitung total cost (total biaya barang dari harga asli dan kuantitas)
                    $cost_query = "SELECT SUM(ti.quantity * p.original_price) AS total_cost
                    FROM transaction_items ti
                    JOIN products p ON ti.product_id = p.product_id
                    WHERE EXISTS (
                    SELECT 1 FROM transactions 
                    WHERE transactions.transactions_id = ti.transaction_id 
                    AND $dateFilter
                    )";
                    $cost_result = mysqli_query($conn, $cost_query);
                    $total_cost = mysqli_fetch_assoc($cost_result)['total_cost'];

                    // Menghitung profit (untung)
                    $profit = $total_revenue - $total_cost;
                ?>

                <h3>Profit Calculation</h3>
                    <p>Total Revenue: <?= number_format($total_revenue ?? 0, 2) ?></p>
                    <p>Total Cost: <?= number_format($total_cost ?? 0, 2) ?></p>
                    <p>Profit: <?= number_format(($total_revenue ?? 0) - ($total_cost ?? 0), 2) ?></p>
            </div>
        </div>
    </div>
</body>
</html>