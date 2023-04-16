<?php require 'inc/head.php'; ?>
<?php require 'inc/data/products.php'; ?>
<?php
if ($_SERVER['REQUEST_METHOD'] === "GET") {
    // WE MANAGE ADD CART OPERATION
    if (!empty($_GET)) {

        //CLEAN DATAS
        $data = array_map('trim', $_GET);

        //CHECK DELETE CART METHOD IS CALLED
        if (!empty($data['delete_cart']) && $data['delete_cart'] === 'yes') {
            $_SESSION = array();
            session_destroy();
            unset($_SESSION);
            header('location: index.php');
        }

        //CHECK REMOVE ITEM CART METHOD IS CALLED
        if (!empty($data['remove_item'])) {
            $key =  array_search($data['remove_item'], $_SESSION['cart']);
            unset($_SESSION['cart'][$key]);
            header('location: cart.php');
        }
    }
}
?>

<section class="cookies container-fluid">
    <div class="row">
        <table class="cart-items">
            <thead>
                <th> Item </th>
                <th> Qte </th>
                <th> </th>
            </thead>
            <tbody>
                <?php foreach (array_count_values($_SESSION['cart']) as $cartKey => $qte) : ?>
                    <tr>
                        <td><?= $catalog[$cartKey]['name'] ?></td>
                        <td><?= $qte ?></td>
                        <td>
                            <a href="?remove_item=<?= $cartKey ?>">
                                <span class="glyphicon glyphicon-minus-sign" aria-hidden="true"></span>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3">
                        Total Product(s) : <?= count($_SESSION['cart']) ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <a href="?delete_cart=yes" class="btn btn-primary" role="button">
                            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Reset cart
                        </a>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>

</section>
<?php require 'inc/foot.php'; ?>