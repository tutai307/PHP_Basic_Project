<div class="container my-4">
    <?php
    if ($bientam == 'quanlydanhmucsanpham' && $query == 'them') {
        include("./pages/quanlydanhmucsp/them.php");
        include("./pages/quanlydanhmucsp/lietke.php");
    } else if ($bientam == 'quanlydanhmucsanpham' && $query == 'sua') {
        include("./pages/quanlydanhmucsp/sua.php");
    } else if ($bientam == 'product' && $query == 'them') {
        include("./pages/Product/ProductIndex.php");
        include("./pages/Product/AddProductPopup.php");
    } else if ($bientam == 'product' && $query == 'sua') {
        include("./pages/Product/EditProductPopup.php");
    } else if ($bientam == 'quanlynguoidung' && $query == 'them') {
        include("./pages/quanlynguoidung/lietke.php");
    } else if ($bientam == 'quanlynguoidung' && $query == 'sua') {
        include("./pages/quanlynguoidung/sua.php");
    } else if ($bientam == 'order' && $query == 'them') {
        include("./pages/quanlydonhang/lietke.php");
    } else if ($bientam == 'order' && $query == 'sua') {
        include("./pages/quanlydonhang/sua.php");
    } else if ($bientam == 'order' && $query == 'xemdonhang') {
        include("./pages/quanlydonhang/xemdonhang.php");
    } else if ($bientam == 'dangxuat') {
        include("Login.php");
    } else {
        include("Dashboard.php");
    }

    ?>

</div>