<link rel="stylesheet" href="css/style_menu.css">
<ul class="admincp_list">

    <li><a href="index.php?action=quanlysanpham&query=them">Quản lý sản phẩm </a></li>

    <?php
        if(isset($_SESSION['dangnhap'])){
            if($_SESSION['dangnhap']=='admin'){
    ?>
    <li><a href="index.php?action=quanlydanhmucsanpham&query=them">Quản lý danh mục sản phẩm </a></li>
    <li><a href="index.php?action=quanlynguoidung&query=them">Quản lý người dùng</a></li>

    <?php
        }
    } 
    ?>
    <li><a href="index.php?action=quanlydonhang&query=them">Quản lý đơn hàng </a></li>
    <li>
        <?php
	if(isset($_GET['dangxuat'])&&$_GET['dangxuat']==1){
		unset($_SESSION['dangnhap']);
		header('Location:login.php');
	}
?>
        <p><a href="index.php?dangxuat=1">Đăng xuất : <?php if(isset($_SESSION['dangnhap'])){
		echo $_SESSION['dangnhap'];

	} ?></a></p>
    </li>
</ul>