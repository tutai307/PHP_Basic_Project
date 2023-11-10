<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="text-center text-white">Thêm sản phẩm</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="productForm" method="POST" action="pages/Product/ProductLogic.php" enctype="multipart/form-data">
                    <table border="1" width="100%" padding="10px" style="border-collapse: collapse;">
                        <tr>
                            <td class="row">
                                <div class="mb-2 col">
                                    <label for="exampleFormControlInput1" class="form-label">Tên sản phẩm</label>
                                    <input name="name" type="text" class="form-control" id="exampleFormControlInput1">
                                </div>
                                <div class="mb-2 col">
                                    <label for="exampleFormControlInput1" class="form-label">Mã sản phẩm</label>
                                    <input name="code" type="text" class="form-control" id="exampleFormControlInput1">
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td class="row">
                                <div class="mb-2 col">
                                    <label for="exampleFormControlInput1" class="form-label">Giá</label>
                                    <input name="price" type="text" class="form-control" id="exampleFormControlInput1">
                                </div>

                                <div class="mb-2 col">
                                    <label for="exampleFormControlInput1" class="form-label">Số lượng</label>
                                    <input name="quantity" type="text" class="form-control" id="exampleFormControlInput1">
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td class="row">
                                <div class="col-6">
                                    <img class="imageInPopup" src="pages/Product/ProductImages/<?php echo $row['hinhanh'] ?>">
                                </div>

                                <div class="col-6 flex-center flex-column">
                                    <label for="exampleFormControlInput1" class="form-label">
                                        Hình ảnh
                                    </label>
                                    <input type="file" name="image" class="form-control" id="exampleFormControlInput1">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="row">
                                <div class="mb-2 col">
                                    <label for="exampleFormControlTextarea1" class="form-label">Mô tả</label>
                                    <textarea name="des" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td class="row">
                                <div class="mb-2 col">
                                    <label for="exampleFormControlInput1" class="form-label">Danh mục</label>
                                    <select name="categoryname" class="form-select" aria-label="Default select example">
                                        <?php
                                        $sql_danhmuc = "SELECT * FROM tbl_category ORDER BY id DESC";
                                        $query_danhmuc = mysqli_query($connect, $sql_danhmuc);
                                        while ($row_danhmuc = mysqli_fetch_array($query_danhmuc)) {
                                        ?>
                                            <!--dùng value thêm danh mục dựa vào địa chỉ id_danhmuc -->
                                            <option value="<?php echo $row_danhmuc['id'] ?>">
                                                <?php echo $row_danhmuc['name'] ?>
                                            </option>


                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="mb-2 col">
                                    <label for="exampleFormControlInput1" class="form-label">Size</label>
                                    <select name="size" class="form-select" aria-label="Default select example" multiple>
                                        <?php
                                        $sql_size = "SELECT * FROM tbl_size ORDER BY id DESC";
                                        $query_size = mysqli_query($connect, $sql_size);
                                        while ($row_size = mysqli_fetch_array($query_size)) {
                                        ?>
                                            <!--dùng value thêm danh mục dựa vào địa chỉ id_size -->
                                            <option value="<?php echo $row_size['quantity'] ?>">
                                                <?php echo $row_size['name'] ?>
                                            </option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="invalidCheck" required>
                                        <label class="form-check-label" for="invalidCheck">
                                            Bạn chắc chắn về thông tin thêm sản phẩm?
                                        </label>
                                        <div class="invalid-feedback">
                                            You must agree before submitting.
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary pt-2 pb-2" data-bs-dismiss="modal">Đóng</button>

                <button type="submit" class="btn btn-primary" name="addProduct">Thêm sản phẩm</button>
            </div>
            </form>
        </div>
    </div>
</div>