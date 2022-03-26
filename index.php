 <?php include 'inc/header.php'; ?>
 <?php include 'inc/slider.php'; ?>
	
 <div class="main">
    <div class="content">
    	<div class="content_top">
    		<div class="heading">
    		<h3>Feature Products</h3>
    		</div>
    		<div class="clear"></div>
    	</div>

	      <div class="section group">

    	<?php
           $getFpd = $pd->getAllFdProduct();
           if($getFpd){
           	 while($resultFpd = $getFpd->fetch_assoc()){
           	 
    	?>
				<div class="grid_1_of_4 images_1_of_4">
					 <a href="details.php?proid=<?php echo $resultFpd['productId']; ?>"><img src="admin/<?php echo $resultFpd['image']; ?>" alt="" /></a>
					 <h2><?php echo $resultFpd['productName']; ?> </h2>
					 <p><?php echo $fm->textShorten($resultFpd['body'],60); ?></p>
					 <p><span class="price">$<?php echo $resultFpd['price']; ?></span></p>
				     <div class="button"><span><a href="details.php?proid=<?php echo $resultFpd['productId']; ?>" class="details">Details</a></span></div>
				</div>

			<?php } } ?>
				
			</div>
			<div class="content_bottom">
    		<div class="heading">
    		<h3>New Products</h3>
    		</div>
    		<div class="clear"></div>
    	</div>
			<div class="section group">

				<?php
                  $getNpd = $pd->getAllNpd();

                  if($getNpd){
                  	while($newpdResult = $getNpd->fetch_assoc()){

                  	
				?>
				<div class="grid_1_of_4 images_1_of_4">
					 <a href="details.php?proid=<?php echo $newpdResult['productId']; ?>"><img src="admin/<?php echo $newpdResult['image']; ?>" alt="" /></a>
					 <h2><?php echo $newpdResult['productName']; ?></h2>
					 <p><span class="price">$<?php echo $newpdResult['price']; ?></span></p>
				     <div class="button"><span><a href="details.php?proid=<?php echo $newpdResult['productId']; ?>" class="details">Details</a></span></div>
				</div>
				<?php  } } ?>
			</div>
    </div>
 </div>
</div>

 <?php include 'inc/footer.php'; ?>