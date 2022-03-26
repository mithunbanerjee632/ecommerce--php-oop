<?php include 'inc/header.php'; ?>

<?php
   $login = Session::get('cuslogin');
    if($login == false){
       header("Location:login.php");
    }
?>

<?php
   $custid      = Session::get('cusId');
  if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])){
    $updtcustPro = $cstmr->updateCustProfile($_POST,$custid);
    }
?>  

<style>
	.tblone{width:550px; margin:0 auto; border:2px solid #ddd;}
	.tblone tr td{text-align:justify;}
	.tblone input[type="text"]{width:400px; font-size:16px; padding:5px;}
</style>
 <div class="main">
    <div class="content">
    	<div class="section group">

<?php
  $id      = Session::get('cusId');
  $getData = $cstmr->getCustomerData($id);
  if($getData){
  	while($result = $getData->fetch_assoc()){

?>    

 		
          <form action="" method="post">
			<table class="tblone">
				  <?php 
				    if(isset($updtcustPro)){
				       echo "<tr><td colspan='2'>".$updtcustPro."</td>></tr>";
				     } 
				   ?>
				<tr>
				  <td></td>	
				  <td colspan="4"><h2>Update Your Profile</h2></td>	
				  
				</tr>
				<tr>
				  <td>Name</td>	
				  <td><input type="text" name="name" value="<?php echo $result['name']; ?>"/></td>
				  	
				</tr>

				<tr>
				  <td>Email</td>	
				   <td><input type="text" name="email" value="<?php echo $result['email']; ?>"/></td>		
				 
				</tr>

				<tr>
				  <td>Phone</td>	
				  <td><input type="text" name="phone" value="<?php echo $result['phone']; ?>"/></td>		
				  
				</tr>

				<tr>
				  <td>City</td>	
				  <td><input type="text" name="city" value="<?php echo $result['city']; ?>"/></td>		
				  
				</tr>

				<tr>
				  <td>Address</td>		
				  <td><input type="text" name="address" value="<?php echo $result['address']; ?>"/></td>	
				</tr>

				<tr>
				  <td>Zipcode</td>	
				  <td><input type="text" name="zip" value="<?php echo $result['zip']; ?>"/></td>	
				</tr>

				<tr>
				  <td>Country</td>		
				  <td><input type="text" name="country" value="<?php echo $result['country']; ?>"/></td>	
				</tr>


				<tr>
				  <td></td>	
				  <td><input type="submit" name="submit" value="Save"/></td>	
				</tr>
			</table>
		 </form>		

		<?php } } ?>
 		</div>
 	</div>
</div>
 <?php include 'inc/footer.php'; ?>