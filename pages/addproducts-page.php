<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Barang</title>

    <!-- My style -->
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
            margin: 1rem 0 0 3rem;
            padding: 20px;
        }

        .addp-container {
            display: flex;
        }

        .content {
            flex-grow: 1;
            padding: 20px;
            background: var(--primary);
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-left: 20px; /* Space between sidebar and content */
        }

        .judul {
            text-align: center;
            margin-bottom: 20px;
            color: var(--font);
        }

        .link {
            margin-bottom: 20px;
        }

        .addproduct-form {
            max-width: 400px;
            margin: 0 auto;
        }

        .addproduct-form label {
            display: block;
            margin: 10px 0 5px;
            color: var(--font);
        }

        .addproduct-form input[type="text"],
        .addproduct-form input[type="number"],
        .addproduct-form input[type="file"],
        .addproduct-form button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .addproduct-form input[type="file"] {
            background-color: var(--third);
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .addproduct-form button {
            background-color: var(--nav);
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .addproduct-form button:hover, .link button:hover {
            background-color: var(--font);
        }

        .link button {
            background-color: var(--nav);
            color: white;
            border: none;
            cursor: pointer;
            padding: 1rem 1rem 1rem 1rem;
            border-radius: 0.5rem;
            transition: background-color 0.3s;
        }

        ::file-selector-button {
            display: none;
        }
    </style>
</head>
<body>
    <div class="addp-container">
        <div class="sidebar">
            <?php include 'sidebar.php'; ?>
        </div>
        <div class="content">
            <div class="judul">
                <h2>Tambah Barang</h2>
            </div>
            <div class="link">
                <a href="stores-page.php"><button>Kembali</button></a>
            </div>
            <hr>
            <div class="addproduct-form">
                <form action="../process/addproducts.php" method="post" enctype="multipart/form-data">
                    <label for="pname">Nama Barang : </label>
                    <input type="text" name="pname" id="pname" required> <br>
                    <label for="original_price">Harga Asli : </label>
                    <input type="number" name="original_price" id="original_price" step="0.01" required> <br>
                    <label for="selling_price">Harga Jual : </label>
                    <input type="number" name="selling_price" id="selling_price" step="0.01" required> <br>
                    <label for="stock">Stok Barang : </label>
                    <input type="number" name="stock" id="stock" required> <br>
                    <label for="img">Upload Gambar : </label> 
                    <input type="file" name="img" id="img" required>
                    <input type="hidden" name="stores_id" value="<?php echo $_SESSION['store_id'];?>">
                    <button type="submit" name="submit">Tambah</button>
                </form>
            </div>
        </div>
        
    </div>
</body>
</html>
