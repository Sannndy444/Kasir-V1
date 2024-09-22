<?php
require '../config/config.php';
session_start();

// Memeriksa apakah pengguna memiliki akses ke halaman ini
if ($_SESSION["role"] !== 'admin' && $_SESSION["role"] !== 'kasir') {
    echo "<script>alert('Access denied.');</script>";
    header("Location: ../pages/dashboard-page.php");
    exit;
}

$store_id = $_SESSION['store_id']; // Mengambil store_id dari session

// Ambil data produk dari database berdasarkan store_id
$product_query = "SELECT * FROM products WHERE store_id = '$store_id'";
$product_result = mysqli_query($conn, $product_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Page</title>

    <!-- My style -->
    <link rel="stylesheet" href="../css/styles.css">
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
            color: #fff;
            background-color: var(--bg);
            overflow-x: hidden;
        }

        .tra-container {
            display: flex;
        }

        .content {
            flex-grow: 1;
            background-color: var(--primary);
            padding: 20px;
            border-radius: 8px;
            box-shadow: var(--nav);
            margin-left: 60px;
        }

        .content h2 {
            font-size: 24px;
            margin-bottom: 20px;
            color: var(--font);
        }

        .judul h2 {
            font-size: 24px;
            text-align: center;
            margin-bottom: 20px;
            color: var(--font);
        }

        .products {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin-bottom: 20px;
        }

        .product-item {
            width: 150px;
            background-color: var(--bg);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 15px;
            margin: 10px;
            box-shadow: var(--nav);
            text-align: center;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .product-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
        }

        .product-item img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .product-item p {
            margin: 5px 0;
            color: var(--font);
        }

        .product-item p:first-child {
            font-weight: bold;
            font-size: 16px;
        }



        #transaction-list {
            background-color: var(--nav);
            border: 1px solid var(--border-color);
            padding: 15px;
            border-radius: 8px;
            box-shadow: var(--shadow);
        }

        #transaction-items {
            list-style-type: none;
            padding: 0;
            margin-bottom: 10px;
        }

        #transaction-items li {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid var(--nav);
            font-size: 14px;
        }

        #transaction-items li:last-child {
            border-bottom: none;
        }

        #transaction-items button {
            background-color: transparent;
            border: none;
            color: var(--accent-color);
            cursor: pointer;
            font-size: 1rem;
            padding-left: 10px;
        }

        #transaction-items button:hover {
            text-decoration: underline;
        }

        #total-price {
            font-weight: bold;
            font-size: 18px;
            color: var(--primary);
        }

        #customer-name {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid var(--border-color);
            border-radius: 5px;
            font-size: 14px;
        }

        .checkout {
            background-color: #6EC207;
            color: var(--primary);
            border: none;
            padding: 12px;
            width: 100%;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .checkout:hover {
            background-color: var(--nav);
        }
    </style>
</head>
<body>
    <div class="tra-container">
        <div class="sidebar">
            <?php include 'sidebar.php'; ?>
        </div>
        <div class="content">
            <div class="judul">
                <h2>Point Of Sale</h2>
            </div>
            <div class="products">
                <?php
                // Tampilkan data produk
                if (mysqli_num_rows($product_result) > 0) {
                    while ($product = mysqli_fetch_assoc($product_result)) {
                        echo '<div class="product-item" onclick="addToTransaction(' . $product['product_id'] . ', \'' . $product['product_name'] . '\', ' . $product['price'] . ')">';
                        echo '<img src="../uploads/' . $product['image'] . '" alt="' . $product['product_name'] . '" width="100px" height="100px">';
                        echo '<p>' . $product['product_name'] . '</p>';
                        echo '<p>Price: ' . $product['price'] . '</p>';
                        echo '</div>';
                    }
                } else {
                    echo 'No products available.';
                }
                ?>
            </div>

            <h2>Transaction List</h2>
                <div id="transaction-list">
                    <input type="text" id="customer-name" placeholder="Enter customer name">
                    <ul id="transaction-items"></ul>
                    <p>Total: <span id="total-price">0</span></p>
                    <button class="checkout" onclick="checkout()">Checkout</button>
                </div>
            </div>
    </div>

    <script>
        let transactionItems = [];
        let totalPrice = 0;

        function addToTransaction(productId, productName, productPrice) {
            // Cek apakah produk sudah ada dalam daftar transaksi
            const existingProduct = transactionItems.find(item => item.id === productId);
            if (existingProduct) {
                // Jika produk sudah ada, tambahkan quantity dan update total harga
                existingProduct.quantity++;
                existingProduct.totalPrice += productPrice;
            } else {
                // Jika produk belum ada, tambahkan produk baru ke daftar transaksi
                transactionItems.push({ 
                    id: productId, 
                    name: productName, 
                    price: productPrice, 
                    quantity: 1,
                    totalPrice: productPrice 
                });
            }

            totalPrice += productPrice;
            renderTransactionList();
        }

        function removeFromTransaction(productId) {
            // Hapus produk dari daftar transaksi
            const productIndex = transactionItems.findIndex(item => item.id === productId);
            if (productIndex > -1) {
                const product = transactionItems[productIndex];
                totalPrice -= product.totalPrice;
                transactionItems.splice(productIndex, 1);
            }

            renderTransactionList();
        }

        function renderTransactionList() {
            const transactionList = document.getElementById('transaction-items');
            transactionList.innerHTML = ''; // Kosongkan daftar sebelum di-render ulang

            transactionItems.forEach(item => {
                const listItem = document.createElement('li');
                listItem.textContent = `${item.name} - ${item.price} x ${item.quantity} pcs = ${item.totalPrice}`;

                // Tombol untuk menghapus item dari transaksi
                const removeButton = document.createElement('button');
                removeButton.textContent = 'Cancel';
                removeButton.onclick = () => removeFromTransaction(item.id);
                
                listItem.appendChild(removeButton);
                transactionList.appendChild(listItem);
            });

            // Update total harga
            document.getElementById('total-price').textContent = totalPrice;
        }

        function checkout() {
            const customerName = document.getElementById('customer-name').value || 'Anonymous'; // Default nama customer jika tidak diisi

            console.log('Checkout initiated with items:', transactionItems); // Debug log
            console.log('Customer name:', customerName); // Debug log

            // Kirim data transaksi dan nama customer ke server untuk mengurangi stok produk
            fetch('../process/checkout.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    transactionItems: transactionItems,
                    customerName: customerName
                })
            })
            .then(response => response.json())
            .then(data => {
                console.log('Server response:', data); // Debug log
                if (data.success) {
                    alert('Transaction successful!');
                    transactionItems = []; // Reset daftar transaksi
                    totalPrice = 0;
                    renderTransactionList();
                    document.getElementById('customer-name').value = ''; // Reset nama customer
                } else {
                    alert('Transaction failed: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    </script>
</body>
</html>
