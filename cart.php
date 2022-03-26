<?php include 'inc/header.php'; ?>



<?php
   if(isset($_GET['delcart'])){
   	$delcartId =  mysqli_real_escape_string($this->db->link, $_GET['delcart']);
   	$delCartpro = $cart->delCartProduct($delcartId);
   }
?>

<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
      $cartId = $_POST['cartId']; 
      $quantity = $_POST['quantity'];
      $updateCartQ = $cart->updateCartQuantity($cartId,$quantity);

      if($quantity <= 0){
      	$delCartpro = $cart->delCartProduct($delcartId);
      }
   }

?>

<?php
  if(!isset($_GET['id'])){
  	echo "<meta http-equiv='refresh' content = '0; URL=?id=mithu'/>";
  }

?>


 <div class="main">
    <div class="content">
    	<div class="cartoption">		
			<div class="cartpage">
			    	<h2>Your Cart</h2>

			    	<?php
                       if(isset($updateCartQ)){
                       	echo $updateCartQ;
                       }

                    ?>

                    <?php
                        if(isset($delCartpro)){
                       	echo $delCartpro;
                       }


			    	?>
						<table class="tblone">
							<tr>
								<th width="10%">Sl No</th>
								<th width="30%">Product Name</th>
								<th width="5%">Image</th>
								<th width="10%">Price</th>
								<th width="15%">Quantity</th>
								<th width="15%">Total Price</th>
								<th width="10%">Action</th>
							</tr>

							<?php
                                $getPro = $cart->getCartPro();
                                $i = 0;
                                $sum = 0;
                                if($getPro){
                                	while($getAllPro = $getPro->fetch_assoc()){
                                       $i++;
                                	
							?>
							<tr>
								<td><?php echo $i; ?></td>
								<td><?php echo $getAllPro['productName'];?></td>
								<td><img src="admin/<?php echo $getAllPro['image'];?>" alt=""/></td>
								<td>$ <?php echo $getAllPro['price'];?></td>
								<td>
									<form action="" method="post">
										<input type="hidden" name="cartId" value="<?php echo $getAllPro['cartId'];?>"/>
										<input type="number" name="quantity" value="<?php echo $getAllPro['quantity'];?>"/>
										<input type="submit" name="submit" value="Update"/>
									</form>
								</td>
								<td>$ <?php
                                   $total = $getAllPro['price'] * $getAllPro['quantity'];
                                   echo $total;

								 ?></td>
								<td><a onClick = "return confirm('Are You Sure To Delete !')" href="?delcart = <?php echo $getAllPro['cartId'];?> ">X</a></td>
							</tr>

							<?php 

							    $sum = $sum + $total;
							    session::set("sum", $sum);

							 ?>

						<?php }  } ?>
							
							
							
						</table>

						<?php
                          $getData = $cart->checkCartTable();
						  if($getData){
						?>
						<table style="float:right;text-align:left;" width="40%">
							<tr>
								<th>Sub Total : </th>
								<td>$ <?php echo $sum; ?></td>
							</tr>
							<tr>
								<th>VAT : </th>
								<td>10%</td>
							</tr>
							<tr>
								<th>Grand Total :</th>
								<td>$ <?php 
                                   $vat = $sum * 0.1;
                                   $grandTotal = $vat + $sum;
                                   echo $grandTotal;
								?> </td>
							</tr>
					   </table>

					   <?php
                         }else{
                         	header("Location:index.php");
                         	//echo "Cart Empty! Please Shop Now...";
                         }
					   ?>
					</div>
					<div class="shopping">
						<div class="shopleft">
							<a href="index.php"> <img src="images/shop.png" alt="" /></a>
						</div>
						<div class="shopright">
							<a href="payment.php"> <img src="images/check.png" alt="" /></a>
						</div>
					</div>
    	</div>  	
       <div class="clear"></div>
    </div>
 </div>
</div>
   
<?php include 'inc/footer.php'; ?>   