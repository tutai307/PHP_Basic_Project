<?php
$sql_danhmuc = "SELECT * FROM tbl_danhmuc ORDER BY id_danhmuc DESC";
$query_danhmuc = mysqli_query($connect, $sql_danhmuc);
?>
<?php
if (isset($_GET['dangxuat']) && $_GET['dangxuat'] == 1) {
    unset($_SESSION['dangky']);
}
?>
<div class="menu">
    <div class="menu_list">
        <ul class="menu_list-left">
            <li><img style="width:50px;height:auto;" src="./images/logo.svg" alt="logo"> </li>
            <li> <a href="UserIndex.php">Home</a></li>
            <li> <a href="UserIndex.php?quanly=giohang">Giỏ hàng</a></li>
            <li><a href="">Danh mục</a>
                <ul class="menu_danhmuc">
                    <?php
                    while ($row_danhmuc = mysqli_fetch_array($query_danhmuc)) {

                    ?>
                        <li> <a href="UserIndex.php?quanly=danhmuclist&id=<?php echo $row_danhmuc['id_danhmuc'] ?>"><?php echo $row_danhmuc['tendanhmuc'] ?></a></li>

                    <?php
                    }

                    ?>
                </ul>
            </li>
            <li>
                <Form method="POST" action="UserIndex.php?quanly=timkiem">
                    <input type="text" class="menu-input-text" placeholder="Tìm kiếm....." name="tukhoa">
                    <input type="submit" class="menu-input-submit" name="timkiem" value="Tìm Kiếm">
                </Form>
            </li>
        </ul>
        <ul class="menu_list-right">
            <?php
            if (isset($_SESSION['dangky'])) {
            ?>

                <li><a href="UserIndex.php?quanly=thongtin"> Thông tin</a></li>
                <li> <a href="UserIndex.php?dangxuat=1">Đăng xuất</a></li>
            <?php
            } else {
            ?>
                <li> <a href="UserIndex.php?quanly=dangnhap">Đăng nhập</a></li>
                <li> <a href="UserIndex.php?quanly=dangky">Đăng ký</a></li>
            <?php
            }
            ?>
        </ul>
    </div>
</div>