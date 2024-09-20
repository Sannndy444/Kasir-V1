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
        .product-item {
            display: inline-block;
            margin: 10px;
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
            cursor: pointer;
        }

        #transaction-list {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Products</h2>
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
            <button onclick="checkout()">Checkout</button>
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
