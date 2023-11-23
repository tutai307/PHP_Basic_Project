<?php
include "../../../common/config/Connect.php";

$orderId = "";

if (isset($_POST['addOrderDetail'])) {
    $quantity = $_POST['quantity'];
    $orderId = $_GET['orderId'];
    $sizeId = $_POST['sizeId'];
    $productId = $_POST['productId'];

    //at first check a similar record is stored in database or not,
    //that means an orderProduct with the same productId, sizeId and orderId having existed in the database
    $getSimilarSQL = "SELECT * FROM tbl_order_detail WHERE order_id = '" . $orderId . "'product_id = '" . $productId . "' AND size_id = '" . $sizeId . "'";
    $similarRecord = mysqli_query($connect, $getSimilarSQL);
    $similarRecordCount = mysqli_num_rows($similarRecord);

    if ($similarRecordCount > 0) {
        echo "<script>alert('Đã có bản ghi với cùng sản phẩm và cùng kích cỡ được đặt trong đơn hàng!')</script>";
    } else {
        //check what sizes are exist in specific product
        $getByProductIdAndSizeIdSQL = "SELECT * FROM tbl_product_size WHERE product_id = '" . $productId . "' AND size_id = '" . $sizeId . "'";
        $productSizeRecords = mysqli_query($connect, $getByProductIdAndSizeIdSQL);
        $count = mysqli_num_rows($productSizeRecords);

        if ($count > 0) {
            $productSizeData = mysqli_fetch_array($productSizeRecords);
            $available = $productSizeData['quantity'];

            if ($available < $quantity) {
                echo "<script>alert('Số lượng hiện có không đủ, đang có sẵn: " . $available . "!')</script>";
            } else {
                //execute main logic
                $getProductSQL = "SELECT * FROM tbl_product WHERE id = '$productId'";
                $productData = mysqli_query($connect, $getProductSQL);
                $countProduct = mysqli_num_rows($productData);

                if ($countProduct > 0) {
                    $unitPrice = 0;
                    $currentProduct = mysqli_fetch_array($productData);
                    $eventId = $currentProduct['event_id'];
                    $price = $currentProduct['price'];

                    if (trim($eventId) == "") {
                        $unitPrice = $price;
                    } else {
                        //check whether a product can be discount or not
                        $getProductSQL = "SELECT * FROM tbl_event WHERE id = '$eventId'";
                        $productData = mysqli_query($connect, $getProductSQL);
                        $countEvent = mysqli_num_rows($productData);

                        if ($countEvent > 0) {
                            $currentProduct = mysqli_fetch_array($productData);
                            $discount = $currentProduct['discount'];
                            $unitPrice = $price - $price * floatval($discount / 100);
                        } else {
                            echo "<script>alert('Dữ liệu sản phẩm có sẵn khoong hợp lệ!')</>";
                        }
                    }
                    //remain quantity in database
                    $remain = $available - $quantity;

                    //update quantity in tbl_produt_size
                    $updateQuantity = "UPDATE tbl_product_size SET quantity = '$remain' WHERE product_id ='$productId' AND size_id = '$sizeId' ";
                    $query = mysqli_query($connect, $updateQuantity);

                    //add new record into order detail table
                    $addOrderDetail = "INSERT INTO tbl_order_detail(order_id, product_id, size_id, quantity, unit_price) 
                VALUES ('" . $orderId . "','" . $productId . "','" . $sizeId . "','" . $quantity .  "','" . $unitPrice . "')";
                    mysqli_query($connect, $addOrderDetail);
                } else {
                    echo "<script>alert('Dữ liệu sản phẩm có sẵn khoong hợp lệ!')</>";
                }
            }
        } else {
            echo "<script>alert('Sản phẩm không có kích cỡ phù hợp!')</script>";
        }
    }
}

if (isset($_POST['updateOrderDetail'])) {
    $quantity = $_POST['quantity'];
    $orderId = $_GET['orderId'];
    $sizeId = $_POST['sizeId'];
    $productId = $_POST['productId'];

    $getByProductIdAndSizeIdSQL = "SELECT * FROM tbl_product_size WHERE product_id = '" . $productId . "' AND size_id = '" . $sizeId . "'";
    $productSizeRecords = mysqli_query($connect, $getByProductIdAndSizeIdSQL);
    $count = mysqli_num_rows($productSizeRecords);

    if ($count > 0) {
        $productSizeData = mysqli_fetch_array($productSizeRecords);
        $available = $productSizeData['quantity'];

        if ($available < $quantity) {
            echo "<script>alert('Số lượng hiện có không đủ, đang có sẵn: " . $available . "!')</script>";
        } else {
            //execute main logic
            $getProductSQL = "SELECT * FROM tbl_product WHERE id = '$productId'";
            $productData = mysqli_query($connect, $getProductSQL);
            $countProduct = mysqli_num_rows($productData);

            if ($countProduct > 0) {
                $unitPrice = 0;
                $currentProduct = mysqli_fetch_array($productData);
                $eventId = $currentProduct['event_id'];
                $price = $currentProduct['price'];

                if (trim($eventId) == "") {
                    $unitPrice = $price;
                } else {
                    $getProductSQL = "SELECT * FROM tbl_event WHERE id = '$eventId'";
                    $productData = mysqli_query($connect, $getProductSQL);
                    $countEvent = mysqli_num_rows($productData);

                    if ($countEvent > 0) {
                        $currentProduct = mysqli_fetch_array($productData);
                        $discount = $currentProduct['discount'];
                        $unitPrice = $price - $price * floatval($discount / 100);
                    } else {
                        echo "<script>alert('Dữ liệu sản phẩm có sẵn khoong hợp lệ!')</>";
                    }
                }

                // $getOldOrderDetailSQL ="SELECT * FROM tbl_order_detail WHERE product_id = '".$."';";

                $remain = $available - $quantity;

                //update quantity in tbl_produt_size
                $updateQuantity = "UPDATE tbl_product_size SET quantity = '$remain' WHERE product_id ='$productId' AND size_id = '$sizeId' ";
                $query = mysqli_query($connect, $updateQuantity);

                //add new record into order detail table
                $addOrderDetail = "INSERT INTO tbl_order_detail(order_id, product_id, size_id, quantity, unit_price) 
                VALUES ('" . $orderId . "','" . $productId . "','" . $sizeId . "','" . $quantity .  "','" . $unitPrice . "')";
                mysqli_query($connect, $addOrderDetail);
            } else {
                echo "<script>alert('Dữ liệu sản phẩm có sẵn khoong hợp lệ!')</>";
            }
        }
    } else {
        echo "<script>alert('Sản phẩm không có kích cỡ phù hợp!')</script>";
    }
}

// if (isset($_POST['deleteProductSize'])) {
//     $orderId = $_GET['orderId'];
//     $sizeId = $_GET['sizeId'];

//     $deleteProductSizeSQL = "DELETE FROM tbl_product_size WHERE product_id ='" . $orderId . "' AND size_id = '$sizeId';";

//     mysqli_query($connect, $deleteProductSizeSQL);
// }

header("Location: ../../AdminIndex.php?workingPage=orderDetail&orderId=" . $orderId);
