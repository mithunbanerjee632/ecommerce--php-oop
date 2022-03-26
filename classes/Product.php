<?php
    $filepath = realpath(dirname(__FILE__));
	include_once ($filepath."/../lib/Database.php");
	include_once ($filepath."/../helper/Format.php");
?>

<?php
  Class Product{
  	private $db;
  	private $fm;

  	public function __construct(){
       $this->db = new Database();
  	   $this->fm = new Format();
  	} 

  	public function insertProduct($data, $files){
  		$productName = $this->fm->validation($data['productName']);
  		$catId       = $this->fm->validation($data['catId']);
  		$brandId     = $this->fm->validation($data['brandId']);
  		$body        = $this->fm->validation($data['body']);
  		$price       = $this->fm->validation($data['price']);
  		$type        = $this->fm->validation($data['type']);

  		$productName = mysqli_real_escape_string($this->db->link, $data['productName']);
  		$catId       = mysqli_real_escape_string($this->db->link, $data['catId']);
  		$brandId     = mysqli_real_escape_string($this->db->link, $data['brandId']);
  		$body        = mysqli_real_escape_string($this->db->link, $data['body']);
  		$price       = mysqli_real_escape_string($this->db->link, $data['price']);
  		$type        = mysqli_real_escape_string($this->db->link, $data['type']);

	  	$permited    = array('jpg', 'jpeg', 'png', 'gif');
	    $file_name   = $files['image']['name'];
	    $file_size   = $files['image']['size'];
	    $file_temp   = $files['image']['tmp_name'];

	    $div         = explode('.', $file_name);
	    $file_ext    = strtolower(end($div));
	    $unique_image= substr(md5(time()), 0, 10).'.'.$file_ext;
	    $uploaded_image = "upload/".$unique_image;

	    if($productName == '' || $catId == '' || $brandId == '' || $body == '' || $price == '' || $type == '' || $file_name == ''){
	    	$msg =  "<span class='error'>Fields Must Not Be Empty ! </span>";
	    	return $msg;
	    }elseif ($file_size >1048567) {
	    	echo "<span class='error'>Image Size should be less then 1MB! </span>";
	    	
	    
	    } elseif (in_array($file_ext, $permited) === false) {
		      echo "<span class='error'>You can upload only:-".implode(', ', $permited)."</span>";
		     
	    }else{
	    	move_uploaded_file($file_temp, $uploaded_image);

	    	$query = "INSERT INTO tbl_product(productName,catId,brandId,body,price,image,type)VALUES('$productName','$catId ','$brandId','$body','$price ','$uploaded_image','$type')";

	    	$inserted_row = $this->db->insert($query);
	    	if($inserted_row){
	    		$msg = "<span class='success'>Product Inserted Successfully! </span>";
	    	    return $msg;

	    	}else{
	    		$msg = "<span class='error'>Product Not Inserted ! </span>";
	    	    return $msg;
	    	}
	    }

	  		
  	}

  	public function getAllProduct(){

        //alias

  		$query = "SELECT p.*,c.catName,b.brandName
         FROM tbl_product as p ,tbl_category as c,tbl_brand as b   
         WHERE p.catId = c.catId AND p.brandId = b.brandId
  		 ORDER BY productId DESC";

  		/* INNER JOIN

  		$query = "SELECT tbl_product.*, tbl_category.catName, tbl_brand.brandName FROM tbl_product
  		INNER JOIN tbl_category ON 
  		tbl_product.catId = tbl_category.catId
  		INNER JOIN tbl_brand ON 
  		tbl_product.brandId = tbl_brand.brandId
  		ORDER BY productId DESC";

  		*/
  		$getpro = $this->db->select($query);
  		return $getpro;

  	}

  	public function getAllproByid($proid){
  		$query = "SELECT * FROM tbl_product WHERE productId = '$proid' ";
  		$getpro = $this->db->select($query);
  		return $getpro;
  	}

  	public function updateProduct($data, $files, $proid){

  		$productName = $this->fm->validation($data['productName']);
  		$catId       = $this->fm->validation($data['catId']);
  		$brandId     = $this->fm->validation($data['brandId']);
  		$body        = $this->fm->validation($data['body']);
  		$price       = $this->fm->validation($data['price']);
  		$type        = $this->fm->validation($data['type']);

  		$productName = mysqli_real_escape_string($this->db->link, $data['productName']);
  		$catId       = mysqli_real_escape_string($this->db->link, $data['catId']);
  		$brandId     = mysqli_real_escape_string($this->db->link, $data['brandId']);
  		$body        = mysqli_real_escape_string($this->db->link, $data['body']);
  		$price       = mysqli_real_escape_string($this->db->link, $data['price']);
  		$type        = mysqli_real_escape_string($this->db->link, $data['type']);

	  	$permited    = array('jpg', 'jpeg', 'png', 'gif');
	    $file_name   = $files['image']['name'];
	    $file_size   = $files['image']['size'];
	    $file_temp   = $files['image']['tmp_name'];

	    $div         = explode('.', $file_name);
	    $file_ext    = strtolower(end($div));
	    $unique_image= substr(md5(time()), 0, 10).'.'.$file_ext;
	    $uploaded_image = "upload/".$unique_image;

	    if($productName == '' || $catId == '' || $brandId == '' || $body == '' || $price == '' || $type == ''){
	    	$msg =  "<span class='error'>Fields Must Not Be Empty ! </span>";
	    	return $msg;
	    }else{
	    	if(!empty($file_name )){


				    if ($file_size >1048567) {
				    	echo "<span class='error'>Image Size should be less then 1MB! </span>";
				    	
				    
				    } elseif (in_array($file_ext, $permited) === false) {
					      echo "<span class='error'>You can upload only:-".implode(', ', $permited)."</span>";
					     
				    }else{
				    	move_uploaded_file($file_temp, $uploaded_image);

                                	$query = "UPDATE tbl_product SET 
	                                productName = '$productName',
	                                catId = '$catId',
	                                brandId = '$brandId',
	                                body = '$body',
	                                price = '$price',
	                                image = '$uploaded_image',
	                                type = '$type' 
	                                WHERE productId = '$proid' ";
				    	

				    	$updated_row = $this->db->update($query);
				    	if($updated_row){
				    		$msg = "<span class='success'>Product Updated Successfully! </span>";
				    	    return $msg;

				    	}else{
				    		$msg = "<span class='error'>Product Not Updated ! </span>";
				    	    return $msg;
				    	}
				    }
	              }else{
                        
                        $query = "UPDATE tbl_product SET 
	                                productName = '$productName',
	                                catId = '$catId',
	                                brandId = '$brandId',
	                                body = '$body',
	                                price = '$price',
	                                type = '$type' 
	                                WHERE productId = '$proid' ";
				    	

				    	$updated_row = $this->db->update($query);
				    	if($updated_row){
				    		$msg = "<span class='success'>Product Updated Successfully! </span>";
				    	    return $msg;

				    	}else{
				    		$msg = "<span class='error'>Product Not Updated ! </span>";
				    	    return $msg;
				    	}

	                 }
                   }

                }


                public function branddelById($id){
                	$query = "SELECT * FROM tbl_product WHERE productId = '$id' ";
                	$getdel = $this->db->select($query);
                	if($getdel){
                		while($getdelpro = $getdel->fetch_assoc()){
                			$dellink = $getdelpro['image'];
                			unlink($dellink);
                		}

                	}

                	$delquery = "DELETE FROM tbl_product WHERE productId = '$id' ";
                	$getdelPro = $this->db->delete($delquery);
                	if($getdelPro){
                		$delmsg = "<span class='success'>Product Deleted Successfully !</span>";
                		return $delmsg;
                	}else{
                		$delmsg = "<span class='error'>Product Not  Deleted  ! </span>";
                		return $delmsg;
                	}
                }


                public function getAllFdProduct(){
                	$query = "SELECT * FROM tbl_product WHERE type = '1' ORDER BY productId DESC LIMIT 4 ";
			  		$result = $this->db->select($query);
			  		return $result;
                }

                public function getAllNpd(){
                	$query = "SELECT * FROM tbl_product ORDER BY productId DESC LIMIT 4";
                	$result = $this->db->select($query);
                	return $result;
                }

                public function getDetailsPd($id){
                	$query = "SELECT p.*,c.catName,b.brandName
			         FROM tbl_product as p ,tbl_category as c,tbl_brand as b   
			         WHERE p.catId = c.catId AND p.brandId = b.brandId AND p.productId = '$id' ";
			         $result = $this->db->select($query);
	                 return $result;
                }

                public function latestFromIphone(){
                	$query = "SELECT * FROM tbl_product WHERE brandId = '1' ORDER BY productId DESC LIMIT 1";
                	$result = $this->db->select($query);
                	return $result;
                }


                public function latestFromSamsung(){
                	$query = "SELECT * FROM tbl_product WHERE brandId = '2' ORDER BY productId DESC LIMIT 1";
                	$result = $this->db->select($query);
                	return $result;
                }

                public function latestFromAcer(){
                	$query = "SELECT * FROM tbl_product WHERE brandId = '3' ORDER BY productId DESC LIMIT 1";
                	$result = $this->db->select($query);
                	return $result;
                }

                public function latestFromCanon(){
                	$query = "SELECT * FROM tbl_product WHERE brandId = '4' ORDER BY productId DESC LIMIT 1";
                	$result = $this->db->select($query);
                	return $result;
                }


                public function getAllCatProById($catid){
                  $query = "SELECT * FROM tbl_Product WHERE catId = '$catid' ";
                  $result = $this->db->select($query);
                  return $result;
                }

                public function insertCompareData($cusId,$productId){
                  $cusId = $this->fm->validation($cusId);
                  $productId = $this->fm->validation($productId);

                  $cusId = mysqli_real_escape_string($this->db->link, $cusId);
                  $productId = mysqli_real_escape_string($this->db->link, $productId);

                  $chkquery = "SELECT * FROM tbl_compare WHERE productId = '$productId' AND cusId = '$cusId'";
                  $checkResult = $this->db->select($chkquery);
                  if($checkResult){
                    $msg = "<span class='error'>Product Already Added !</span>";
                    return $msg;
                  }

                  $query = "SELECT * FROM tbl_product WHERE productId = '$productId' ";
                  $getPro = $this->db->select($query)->fetch_assoc();
                  if($getPro){
                    
                      $productId   = $getPro['productId'];
                      $productName = $getPro['productName'];
                      $image       = $getPro['image'];
                      $price       = $getPro['price'];
                       
                    $insrtquery = "INSERT INTO  tbl_compare(cusId,productId,productName,image,price)VALUES('$cusId','$productId ','$productName','$image','$price')";

                    $inserted_row = $this->db->insert($insrtquery);

                    if($inserted_row){
                        $msg = "<span class='success'>Added! Check Compare list</span>";
                        return $msg;
                      }else{
                        $msg = "<span class='error'> Already Added ! </span>";
                        return $msg;
                      }
                        
                     }

                }


                public function getCompareData($cusId){
                  $cusId = $this->fm->validation($cusId);
                  $cusId = mysqli_real_escape_string($this->db->link, $cusId);

                  $query = "SELECT * FROM tbl_compare WHERE cusId = '$cusId' ORDER BY id DESC";
                  $result = $this->db->select($query);
                  return $result;
                }


                public function delCmprData($cusId){
                  $delquery = "DELETE FROM tbl_compare WHERE cusId = '$cusId' ";
                  $cmprDelPro = $this->db->delete($delquery);
                  return $cmprDelPro;
                }

                public function insertWislistData($custid,$productId){
                  $cusId = $this->fm->validation($custid);
                  $productId = $this->fm->validation($productId);

                  $cusId = mysqli_real_escape_string($this->db->link, $custid);
                  $productId = mysqli_real_escape_string($this->db->link, $productId);

                  $chkquery = "SELECT * FROM tbl_wishlist WHERE productId = '$productId' AND cusId = '$cusId'";
                  $checkResult = $this->db->select($chkquery);
                  if($checkResult){
                    $msg = "<span class='error'>Product Already Added !</span>";
                    return $msg;
                  }

                  $query = "SELECT * FROM tbl_product WHERE productId = '$productId'";
                  $result = $this->db->select($query)->fetch_assoc();
                  if($result){
                      $productId = $result['productId'];
                      $productName = $result['productName'];
                      $price = $result['price'];
                      $image = $result['image'];

                      
                    $query = "INSERT INTO tbl_wishlist(cusId,productId,productName,price,image)VALUES('$cusId','$productId ','$productName','$price','$image')";

                        $inserted_row = $this->db->insert($query);
                        
                     }

                      if($inserted_row){
                        $msg = "<span class='success'>Added ! Check Wishlist !</span>";
                        return $msg;
                      }else{
                        $msg = "<span class='error'> Already  Added ! </span>";
                        return $msg;
                      }

                    }



                
                public function getWishllistData($cusId){
                  $cusId = $this->fm->validation($cusId);
                  $cusId = mysqli_real_escape_string($this->db->link, $cusId);

                  $query = "SELECT * FROM tbl_wishlist WHERE cusId = '$cusId' ORDER BY id DESC";
                  $result = $this->db->select($query);
                  return $result;
                }

                public function getWislistData($cusId,$productId){
                  $cusId = $this->fm->validation($cusId);
                  $productId = $this->fm->validation($productId);

                  $cusId = mysqli_real_escape_string($this->db->link, $cusId);
                  $productId = mysqli_real_escape_string($this->db->link, $productId);

                  $query = "DELETE FROM tbl_wishlist WHERE cusId = '$cusId' AND productId = '$productId'";
                  $getData = $this->db->delete($query);

                }


             
            }

        

           

?>