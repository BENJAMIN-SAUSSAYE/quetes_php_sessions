<?php require 'inc/data/products.php'; ?>
<?php require 'inc/head.php'; ?>
<?php
//  INITIALISE VARIABLES
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === "GET") {

    // WE MANAGE ADD CART OPERATION
    if (!empty($_GET)) {
        //CLEAN DATAS
        $data = array_map('trim', $_GET);

        //CHECK ADD CART METHOD IS CALLED
        if (!empty($data['add_to_cart'])) {

            //CHECK DATAS VALUE AND FORMAT
            //filter_var --> Returns false if the filter fails. 
            if (filter_var($data['add_to_cart'], FILTER_VALIDATE_INT) === FALSE) {
                $errors[] = 'The product identifier must be an integer value.';
            }

            // CHECK POSITIVE VALUE
            if ($data['add_to_cart'] <= 0) {
                $errors[] = 'The product identifier must be a positive value.';
            }

            // CHECK ID IS IN THE PRODUC CATALOG
            if (!in_array($data['add_to_cart'], array_keys($catalog))) {
                $errors[] = 'The given product identifier : ' . $data['add_to_cart'] . ' does not belong catalog.';
            }

            //OK ALL IS GOOD
            if (count($errors) === 0) {
                array_push($_SESSION['cart'], $data['add_to_cart']);
                //redirect to index stop GET with old request
                header('location: index.php');
            }
        }
    }
}
?>
<div class="mess-warning <?= (count($errors) === 0) ? 'hide' : 'show'; ?>">
    <ul>
        <?php foreach ($errors ?? [] as $error) : ?>
            <li>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-circle" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                    <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z" />
                </svg>
                <?= $error ?>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<section class="cookies container-fluid">
    <div class="row">
        <?php foreach ($catalog as $id => $cookie) { ?>
            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                <figure class="thumbnail text-center">
                    <img src="assets/img/product-<?= $id; ?>.jpg" alt="<?= $cookie['name']; ?>" class="img-responsive">
                    <figcaption class="caption">
                        <h3><?= $cookie['name']; ?></h3>
                        <p><?= $cookie['description']; ?></p>
                        <a href="?add_to_cart=<?= $id; ?>" class="btn btn-primary">
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add to cart
                        </a>
                    </figcaption>
                </figure>
            </div>
        <?php } ?>
    </div>
</section>
<?php require 'inc/foot.php'; ?>