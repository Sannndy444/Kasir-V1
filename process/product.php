<?php 
require '../config/config.php';

if(isset($_SESSION['store_id'])){
    $store_id = $_SESSION['store_id'];
    $result = mysqli_query($conn, "SELECT * FROM products WHERE store_id = $store_id");
    if($result && mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
            $image = $row['image'];
            $pname = $row['product_name'];
            $price = $row['price'];
            $pstock = $row['stock'];
        }
    } else {
        echo "<script>alert('Tidak ada data yang ditemukan.');</script>";
    }
}