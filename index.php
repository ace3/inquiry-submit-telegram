<?php include_once('configuration.php');?>
<?php include_once('cart.php');?>
<?php include_once('logic.php');?>
<?php include_once('price.php');?>
<?php //var_dump($profile); die();?>
<!doctype html>
<html lang="en">
  <head>
    <title><?php echo $title;?></title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  </head>
  <body class="bg-light">

    <div class="container">
      <div class="py-5 text-center">
        <img class="d-block mx-auto mb-4" src="https://getbootstrap.com/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
        <h2>Checkout form</h2>
        <p class="lead">Below is an example form built entirely with Bootstrap's form controls. Each required form group has a validation state that can be triggered by attempting to submit the form without completing it.</p>
      </div>

      <div class="row">
        <div class="col-md-4 order-md-2 mb-4">
          <h4 class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-muted">Your order</span>
            <span class="badge badge-secondary badge-pill"><?php echo $cart_counter;?></span>
          </h4>
          <button type="button" class="btn btn-info btn-lg btn-block"  data-toggle="modal" data-target="#myModal" >Select Product</button>

          <hr class="mb-3">

            <h4 class="mb-3">Your Order List</h4>
          <ul class="list-group mb-3">
            <?php $subtotal = 0;?>
            <?php $counter =0;?>
            <?php foreach ($cart as $key => $item) :?>       
                <?php $product_id = $item['product_id'];
                foreach($products as $product)
                {
                    if($product['id']== $product_id)
                    {?>
                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                        <div>
                            <h6 class="my-0"><?php echo $product['product_name'];?> x <?php echo $item['qty'];?> Pcs</h6>
                            <small class="text-muted"><?php echo $product['description'];?></small>
                            <small class="text-muted">@ Rp. <?php echo number_format($product['price'],0,',','.');?></small>
                            <small class="text-muted"><a href="kill.php?kill=<?php echo $key; ?>"><span style="color:red" >X</span></a></small>
                        </div>
                        <?php $total_price = $item['qty'] * $product['price'];
                        $subtotal = $subtotal+$total_price;
                        ?>
                        <span class="text-muted">Rp. <?php echo number_format($total_price,0,',','.');?></span>
                    </li>
                    <?php }
                }?>   
                <?php $counter++;?>                 
            <?php endforeach;?>
            <li class="list-group-item d-flex justify-content-between">
              <span>Total (IDR)</span>
              <strong>Rp. <?php echo number_format($subtotal,0,',','.');?></strong>
            </li>
          </ul>

          <form method="post" action="submit.php" class="card p-2">
            <button <?php if(sizeof($cart)==0){ echo ' disabled ';}?> type="button" name="message" id="message" class="btn btn-dark btn-lg btn-block">Send Inquiry</button>
          </form>
        </div>
        <div class="col-md-8 order-md-1">
          <h4 class="mb-3">Order Information</h4>
          <form  method="post" action="profile.php" class="needs-validation" novalidate>
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="name">Name</label>
                <input type="text" name="name"  class="form-control" value="<?php if(isset($profile['name'])) { echo $profile['name'];}?>" id="name" placeholder="" value="" required>
                <div class="invalid-feedback">
                  Valid Name is required.
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <label for="phone">Phone</label>
                <input name="phone" type="number" class="form-control" id="phone" placeholder="" value="<?php if(isset($profile['phone'])) { echo $profile['phone'];}?>" required>
                <div class="invalid-feedback">
                  Valid Phone is required.
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="address">Address</label>
              <textarea class="form-control" name="address" id="address" rows="3"><?php if(isset($profile['address'])) { echo $profile['address'];}?></textarea>
            </div>
            <div class="mb-3">
              <label for="email">Email <span class="text-muted">(Required)</span></label>
              <input type="email" class="form-control" id="email" placeholder="you@example.com" value="<?php if(isset($profile['email'])) { echo $profile['email'];}?>" name="email" required >
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
        <p class="mb-1">&copy; 2017-2018 <?php echo $title;?></p>
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
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="bower_components/bootstrap4/assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="bower_components/bootstrap4/assets/js/vendor/popper.min.js"></script>
    <script src="bower_components/bootstrap4/dist/js/bootstrap.min.js"></script>
    <script src="bower_components/bootstrap4/assets/js/vendor/holder.min.js"></script>
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
  </body>
</html>



<!-- Modal -->

<!-- The Modal -->
<div class="modal fade" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">
    <form method="post" class="needs-validation" novalidate action="add_cart.php">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Select new Product</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
        <div class="form-group">
        <label for="product">Product Selet</label>
        <select class="form-control" name="product" id="product">
        <?php foreach ($products as $value) :?>
            <option value="<?php echo $value['id'];?>"><?php echo $value['product_name'];?></option>
            <?php endforeach;?>
        </select>
        </div>
      
      <div class="form-group">
        <label for="qty">Qty</label>
        <input type="number" required class="form-control" name="qty" id="qty" aria-describedby="qtyId" placeholder="Input Qty of Product">
        <small id="qtyId" class="form-text text-muted">Please input valid Qty</small>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="submit" class="btn btn-warning">Close</button>
      </div>
</form>
    </div>
  </div>
</div>
