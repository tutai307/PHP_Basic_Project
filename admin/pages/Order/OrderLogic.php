<?php
include "../../../common/config/Connect.php";

function generateUuid()
{
    $data = random_bytes(16);

    $data[6] = chr(ord($data[6]) & 0x0F | 0x40);
    $data[8] = chr(ord($data[8]) & 0x3F | 0x80);
    $uuid = vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    return $uuid;
}

if (isset($_POST['addOrder'])) {
    $userId = $_POST['userId'];
    $statusId = $_POST['statusId'];
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    $orderCode = '';

    for ($i = 0; $i < 8; $i++) {
        $orderCode .= $characters[rand(0, strlen($characters) - 1)];
    }

    $receivePhone = $_POST['receivePhone'];
    $transferFee = $_POST['transferFee'];
    $receiveAddress = $_POST['receiveAddress'];
    $description = $_POST['description'];
    $createDate = date('Y-m-d H:i:s');

    $orderId =  generateUuid();
    $add = "INSERT INTO tbl_order(id,code,user_id,status_id,receive_phone,receive_address,delivery_cost,description, createDate) 
    VALUES ('" . $orderId . "','" . $orderCode . "','" . $userId . "','" . $statusId . "','" . $receivePhone . "','" . $receiveAddress . "','" . $transferFee . "','" . $description . "','" . $createDate . "')";

    mysqli_query($connect, $add);
} else if (isset($_POST['editOrder'])) {
    $receivePhone = $_POST['receivePhone'];
    $diachinhan = $_POST['diachinhan'];
    $phigiaohang = $_POST['phigiaohang'];
    $mota = $_POST['mota'];
    $userId = $_POST['userId'];
    $status_id = $_POST['statusId'];

    $sql_editOrder = "UPDATE tbl_order 
    SET 
    receive_phone='" . $receivePhone . "',
    receive_address = '" . $diachinhan . "',
    delivery_cost = '" . $phigiaohang . "' , 
    user_id = '" . $userId . "' , 
    status_id = '" . $status_id . "' , 
    description = '" . $mota . "'
    WHERE id ='$_GET[orderId]' ";

    $query = mysqli_query($connect, $sql_editOrder);
} else if (isset($_POST['deleteOrder'])) {
    $deleteOrder = $_GET['orderId'];
    $sql_xoa = "DELETE FROM tbl_order WHERE id ='$_GET[orderId]';";
    mysqli_query($connect, $sql_xoa);
}

header('Location:../../AdminIndex.php?workingPage=order');
