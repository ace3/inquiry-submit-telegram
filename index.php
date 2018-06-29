<?php include_once 'configuration.php';?>
<?php include_once 'cart.php';?>
<?php include_once 'logic.php';?>
<?php include_once 'price.php';?>

<?php

require_once 'telegram.php';
// Register API keys at https://www.google.com/recaptcha/admin
$siteKey = getenv('CAPTCHA_SITEKEY');
$secret = getenv('CAPTCHA_SECRET');
// reCAPTCHA supported 40+ languages listed here: https://developers.google.com/recaptcha/docs/language
$lang = 'en';

?>
<!doctype html>
<html lang="en">
  <head>
    <title><?php echo $title; ?></title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
     <link rel="stylesheet" href="bower_components/select2/dist/css/select2.min.css">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />

  </head>
  <body class="bg-light">

    <div class="container">
      <div class="py-5 text-center">
        <img class="d-block mx-auto mb-4" src="sticker.svg" alt="" width="72" height="72">
        <h2>Checkout form</h2>
        <p class="lead">Below is an example form built entirely with Bootstrap's form controls. Each required form group has a validation state that can be triggered by attempting to submit the form without completing it.</p>
      </div>

      <div class="row">
        <div class="col-md-6 order-md-2 mb-4">
          <h4 class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-muted">Your order</span>
            <span class="badge badge-secondary badge-pill"><?php echo $cart_counter; ?></span>
          </h4>
          <button type="button" class="btn btn-info btn-lg btn-block"  data-toggle="modal" data-target="#myModal" >Select Product</button>

          <hr class="mb-3">

            <h4 class="mb-3">Your Order List</h4>
          <ul class="list-group mb-3">
            <?php $subtotal = 0;?>
            <?php $counter = 0;?>
            <?php foreach ($cart as $key => $item): ?>
                <?php $product_id = $item['product_id'];
foreach ($products as $product) {

    if ($product['id'] == $product_id) {
        ?>
                      <?php
$variant_extra_cost = R::getAll("
select variants.id as id, variants.name as variant_name,variants.price, variants.cost
from sma_product_variants variants
where variants.id = " . $item['variant']);

        $variant_cost = 0;
        $variant_name = '';
        $variant_price = 0;
        foreach ($variant_extra_cost as $key => $value) {
            $variant_price = $value['price'];
            $variant_cost = $value['cost'];
            $variant_name = $value['variant_name'];
        }

        $total_price = $item['qty'] * ($product['price'] + $variant_price + $variant_cost);
        $subtotal = $subtotal + $total_price;
        ?>
                    <li class="list-group-item  justify-content-between lh-condensed">
                        <div>
                            <h6 class="my-0"><?php echo $product['product_name']; ?> x <?php echo $item['qty']; ?> <?php echo $product['unit_name']; ?></h6>
                            <span class="text-muted pull-right" ><h1>&nbsp&nbsp<a style="color:red;" href="kill.php?kill=<?php echo $key; ?>"><i class="fa fa-trash align-top"></i></a></h1></span>
                          	<h6><small class="text-muted">Variant: <?php echo $variant_name; ?></small></h6>
                            <h6><small class="text-muted">Notes: <?php echo $item['notes']; ?></small></h6>
                            <?php if ($variant_cost != 0): ?> <h6><small class="text-muted">Variant Cost: <b><?php echo number_format($variant_cost, 0, ',', '.'); ?></b></small></h6> <?php endif;?>
                            <?php if ($variant_price != 0): ?> <h6><small class="text-muted">Variant Price: <b><?php echo number_format($variant_price, 0, ',', '.'); ?></b></small></h6> <?php endif;?>
                            <span class="pull-left"><small class="text-muted"><?php echo $item['qty']; ?> x Rp. <?php echo number_format($product['price'], 0, ',', '.'); ?></small></span>
                            <span class="pull-right"><span class="text-muted">Rp. <?php echo number_format($total_price, 0, ',', '.'); ?></span></span>
                        </div>

                    </li>
                    <?php }
}?>
                <?php $counter++;?>
            <?php endforeach;?>
            <li class="list-group-item d-flex justify-content-between">
              <span>Total (IDR)</span>
              <strong>Rp. <?php echo number_format($subtotal, 0, ',', '.'); ?></strong>
            </li>
          </ul>

          <form method="post" action="submit.php" class="card p-2" onsubmit="return confirm('Do you really want to submit the form?');">
          <div class="g-recaptcha" data-sitekey="<?php echo $siteKey; ?>"></div>
            <script type="text/javascript"
                    src="https://www.google.com/recaptcha/api.js?hl=<?php echo $lang; ?>">
            </script>
            <button <?php if (sizeof($cart) == 0) {echo ' disabled ';}?> <?php if (sizeof($profile) == 0) {
    echo ' disabled ';
}?> type="submit" class="btn btn-dark btn-lg btn-block">Send Inquiry</button>
          </form>
        </div>
        <div class="col-md-6 order-md-1">
          <h4 class="mb-3">Order Information</h4>
          <form  method="post" action="profile.php" class="needs-validation" novalidate>
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="name">Name</label>
                <input type="text" name="name"  class="form-control" value="<?php if (isset($profile['name'])) {echo $profile['name'];}?>" id="name" placeholder="" value="" required>
                <div class="invalid-feedback">
                  Valid Name is required.
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <label for="phone">Phone</label>
                <input maxlength="20" name="phone" type="text" class="form-control txtboxToFilter" id="phone" placeholder="" value="<?php if (isset($profile['phone'])) {echo $profile['phone'];}?>" required>
                <div class="invalid-feedback">
                  Valid Phone is required.
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="address">Address</label>
              <textarea class="form-control" name="address" id="address" rows="3"><?php if (isset($profile['address'])) {echo $profile['address'];}?></textarea>
            </div>

            <div class="form-group">
              <label for="expedisi">Expedisi</label>
              <textarea class="form-control" name="expedisi" id="expedisi" rows="3"><?php if (isset($profile['expedisi'])) {
    echo $profile['expedisi'];
}?></textarea>
            </div>

            <div class="mb-3">
              <label for="email">Email <span class="text-muted">(Required)</span></label>
              <input type="email" class="form-control" id="email" placeholder="you@example.com" value="<?php if (isset($profile['email'])) {echo $profile['email'];}?>" name="email" required >
              <div class="invalid-feedback">
                Please enter a valid email address for shipping updates.
              </div>
            </div>
            <hr class="mb-4">
            <button class="btn btn-primary btn-lg btn-block" type="submit">Save your Information</button>
          </form>

        </div>
      </div>

      <footer class="my-5 pt-5 text-muted text-center text-small">
        <p class="mb-1">&copy; 2017-2018 <?php echo $title; ?></p>
        <ul class="list-inline">
          <li class="list-inline-item"><a href="#">Privacy</a></li>
          <li class="list-inline-item"><a href="#">Terms</a></li>
          <li class="list-inline-item"><a href="#">Support</a></li>
        </ul>
      </footer>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> -->
    <script>window.jQuery || document.write('<script src="bower_components/bootstrap4/assets/js/vendor/jquery-slim.min.js"><\/script>')</script>

    <script src="bower_components/bootstrap4/assets/js/vendor/popper.min.js"></script>
    <script src="bower_components/bootstrap4/dist/js/bootstrap.min.js"></script>
    <script src="bower_components/bootstrap4/assets/js/vendor/holder.min.js"></script>
    <script src="bower_components/select2/dist/js/select2.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

    <script>
      // Example starter JavaScript for disabling form submissions if there are invalid fields
      (function() {
        'use strict';

        window.addEventListener('load', function() {
          // Fetch all the forms we want to apply custom Bootstrap validation styles to
          var forms = document.getElementsByClassName('needs-validation');

          // Loop over them and prevent submission
          var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
              if (form.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
              }
              form.classList.add('was-validated');
            }, false);
          });
        }, false);
      })();
    </script>
    <script>
    $(document).ready(function() {
    $('.products').select2({width: 'resolve'});
});
</script>
  <script type="text/javascript">
$(document).ready(function(){

  $('#product').on('change',function(){
    $("#qty").val('') ;
                $("#price").html('');
  });
  $('#variant').on('change',function(){
    $("#qty").val('') ;
                $("#price").html('');
  });

    $('#category').on("change",function () {
        var categoryId = $(this).find('option:selected').val();

        $.ajax({
  type: 'POST',
  url: "ajax.php",
  data: "category="+categoryId,
  success: function (response) {
                console.log(response);
                $("#product").html(response);
            }
});
});
  $('#product').on("change",function () {
        var productID = $(this).find('option:selected').val();

        $.ajax({
  type: 'POST',
  url: "ajaxvariant.php",
  data: "product="+productID,
  success: function (response) {
                console.log(response);
                $("#variant").html(response);
            }
			});
	});
});
</script>
<?php if (isset($_SESSION['message'])): ?>
<script>
alert('<?php echo $_SESSION['message']; ?>');
</script>
<?php unset($_SESSION['message']);
endif;?>

<script>
$(document).ready(function() {
    $(".txtboxToFilter").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl+A, Command+A
            (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
             // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
});
</script>
<script>

  $(document).ready(function(){

$( ".qty" ).change(function() {
      $product_id = $('#product').val();
      $qty = $('#qty').val();
      $variant = $('#variant').val();

      if($qty!=='' && $product_id!== ''&& $product_id!== null && $qty!==null)
      {
console.log($product_id);
$.ajax({
  type: 'POST',
  url: "ajaxprice.php",
  data: "product_id="+$product_id+"&qty="+$qty+"&variant="+$variant,
  success: function (response) {
                console.log(response);
                $("#price").html(response);
            }
});
}
else
{
  alert('Silakan pilih produk.');
}
});
  });

</script>
  </body>
</html>

<!-- Modal -->

<!-- The Modal -->
<div class="modal fade mx-auto" id="myModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
    <form method="post" class="needs-validation" novalidate action="add_cart.php" style="
    margin-left: 10px;
    margin-right: 10px;
">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Select new Product</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

        <!-- Select Category first -->
        <div class="form-group">
        <label for="product">Category Select</label>
        <select required class="form-control product category" name="category" id="category"  style="width:100%;">
          <option value="">Select Category</option>
        <?php foreach ($categories as $value): ?>
            <option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
            <?php endforeach;?>
        </select>
        </div>

        <div class="form-group">
        <label for="product">Product Select</label>
        <select required class="form-control product " name="product" id="product"  style="width:100%;">
        </select>
        </div>

        <div class="form-group">
        <label for="variant">Variant Select</label>
        <select required class="form-control variant " name="variant" id="variant"  style="width:100%;">
        </select>
        </div>

      <div class="form-group">
        <label for="qty">Qty</label>
        <input type="number" required class="form-control qty " name="qty" id="qty" aria-describedby="qtyId" placeholder="Input Qty of Product">
        <small id="qtyId" class="form-text text-muted">Please input valid Qty</small>
      </div>

      <div class="form-group">
        <div class="price" id="price"></div>
      </div>

      <div class="form-group">
        <label for="notes">Notes:</label>
        <textarea class="form-control" rows="3" id="notes" name="notes"></textarea>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="submit" class="btn btn-warning">Add</button>
      </div>
</form>
    </div>
  </div>
</div>
