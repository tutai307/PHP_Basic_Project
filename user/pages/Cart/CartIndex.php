<?php
$show_cart_sql = "SELECT * FROM tbl_cart_detail WHERE tbl_cart_detail.cart_id = '$_COOKIE[cartId]'";
$show_cart_query = mysqli_query($connect, $show_cart_sql);
$cart_empty = mysqli_num_rows($show_cart_query) == 0; // Check if the cart is empty
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>

<body>
<?php if ($cart_empty) : ?>
        <div class="appCard text-center">
            <h1>
                <legend class="text-center fw-bold">Quản lý giỏ hàng</legend>

            </h1>
            <p>Giỏ hàng của bạn đang trống.</p>
        </div>
    <?php else : ?>
        <form action="../../user/pages/Cart/CartLogic.php" method="post">
            <div class="appCard">
                <table class="table">
                    <legend class="text-center fw-bold">Quản lý giỏ hàng</legend>
                    <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">Sản phẩm</th>
                            <th class="text-center align-middle" scope="col">Size</th>
                            <th class="text-center align-middle" scope="col">Đơn giá</th>
                            <th class="text-center align-middle" scope="col">Số lượng</th>
                            <th class="text-center align-middle" scope="col">Số tiền</th>
                            <th class="text-center align-middle" scope="col">Thao tác</th>
                        </tr>
                    </thead>
                    <?php
                    while ($row_cart = mysqli_fetch_array($show_cart_query)) {
                        $show_size_sql = "SELECT * FROM tbl_size
                    WHERE tbl_size.id = '$row_cart[size_id]'";
                        $show_size_query = mysqli_query($connect, $show_size_sql);
                        $row_size = mysqli_fetch_array($show_size_query);

                        $show_image_sql = "SELECT * FROM tbl_product_image WHERE product_id = '$row_cart[product_id]' AND main_image = 1;";
                        $show_image_query = mysqli_query($connect, $show_image_sql);
                        $row_image = mysqli_fetch_array($show_image_query);
                    ?>
                        <tr>
                            <td class="text-center align-middle">
                                <input class="form-check-input float-start" type="checkbox" name="selectedPro[]" id="">
                            </td>
                            <td class="text-center align-middle">
                                <a style="text-decoration: none;" href="UserIndex.php?usingPage=product&id=<?php echo $row_cart['product_id'] ?>">
                                    <div class="product_container flex">
                                        <?php
                                        $imageSource = str_starts_with($row_image['content'], 'http') ? $row_image['content'] : "../../admin/pages/ProductImage/{$row_image['content']}";

                                        echo "<img style=\"width: 150px; height: 150px\" src=\"{$imageSource}\">";
                                        ?>
                                    </div>
                                </a>
                            </td>
                            <td class="text-center align-middle">
                                <?php echo preg_replace('/\D/', '', $row_size['name']); ?>
                            </td>
                            <td class="text-center align-middle">
                                <span class="price_real">
                                    <?php echo number_format($row_cart['unit_price'], 0, ',', '.') . ' đ' ?>
                                </span>
                            </td>
                            <td class="text-center align-middle">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <button type="button" class="btn btn-primary btn-increase">+</button>
                                    <input class="btn btn-outline-primary" id="quantity" name="quantity[]" size="1" min="1" value="<?php echo $row_cart['quantity'] ?>">
                                    <button type="button" class="btn btn-primary btn-decrease">-</button>
                                </div>
                            </td>

                            <td class="text-center align-middle">
                                <span class="price_real" id="total_Price">
                                </span>
                            </td>
                            <td class="text-center align-middle">
                                <button type="button" class="btn btn-danger remove-btn" data-bs-toggle="modal" data-bs-target="#confirmPopup_<?php echo $row_cart['product_id']; ?>">
                                    <i class="fa-solid fa-trash"></i>
                                    Xoá</button>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </table>
                <div class="ml-2 mb-3 form-check">
                    <input name="submit" type="checkbox" class="form-check-input" id="exampleCheck1" required>
                    <label class="form-check-label" for="exampleCheck1">Bạn có muốn xác nhận đơn hàng này?</label>
                </div>
            </div>

            <input type="hidden" name="totalAmount">

            <div class="text-end mt-3">
                Tổng số tiền: <span id="totalAmountDisplay" class="price_real"> <?php echo number_format($totalAmount, 0, ',', '.') . ' đ'; ?></span>
                <button name="confirmBuy" type="submit" class="btn btn-success p-3" id="buyButton">
                    <i class="fa-solid fa-cart-shopping mr-2 ml-0"></i>
                    Mua hàng
                </button>
            </div>
        </form>

        <script>
            $(document).ready(function() {
                updateTotalAmount();

                // Handle checkbox changes
                $('input[name="selectedPro[]"]').change(function() {
                    updateTotalAmount();
                });

                // Increase quantity button click
                $('.btn-increase').click(function() {
                    var quantityElement = $(this).closest('tr').find('.text-center.align-middle:eq(4) input');
                    var currentQuantity = parseInt(quantityElement.val());
                    quantityElement.val(currentQuantity + 1);
                    updateTotalAmount();
                });

                // Decrease quantity button click
                $('.btn-decrease').click(function() {
                    var quantityElement = $(this).closest('tr').find('.text-center.align-middle:eq(4) input');
                    var currentQuantity = parseInt(quantityElement.val());
                    if (currentQuantity > 1) {
                        quantityElement.val(currentQuantity - 1);
                        updateTotalAmount();
                    }
                });

                // Function to update total amount based on selected checkboxes
                function updateTotalAmount() {
                    var totalAmount = 0;

                    // Loop through all items
                    $('input[name="selectedPro[]"]').each(function() {
                        var quantity = parseInt($(this).closest('tr').find('.text-center.align-middle:eq(4) input').val());
                        var unitPriceText = $(this).closest('tr').find('.text-center.align-middle:eq(3) .price_real').text();

                        // Remove non-numeric characters except for the dot
                        var unitPrice = parseInt(unitPriceText.replace(/[^\d]/g, ''));

                        // Update total_Price display for each item individually
                        var total_Price = quantity * unitPrice;
                        $(this).closest('tr').find('.text-center.align-middle:eq(5) #total_Price').text(formatCurrency(total_Price) + ' đ');

                        // Update totalAmount only for checked items
                        if ($(this).is(':checked')) {
                            totalAmount += total_Price;
                        }
                    });

                    // Update the display
                    $('#totalAmountDisplay').text(formatCurrency(totalAmount) + ' đ');

                    // Update the value in the form
                    $('input[name="totalAmount"]').val(totalAmount);
                }

                // Function to format currency with commas
                function formatCurrency(amount) {
                    return amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }
            });
        </script>
        <?php
        $show_cart_query = mysqli_query($connect, $show_cart_sql);

        while ($row_cart = mysqli_fetch_array($show_cart_query)) {
            include "../../user/pages/Cart/CartConfirmDeletePopup.php";
        }
        ?>
    <?php endif; ?>
</body>

</html>