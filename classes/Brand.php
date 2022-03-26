<?php
  $filepath = realpath(dirname(__FILE__));
  include_once ($filepath."/../lib/Database.php");
  include_once ($filepath."/../helper/Format.php");
?>

<?php
  Class Brand{
  	private $db;
  	private $fm;

  	public function __construct(){
  		$this->db = new Database();
  		$this->fm = new Format();
  	}

  	 public function insertBrand($brandName){
  		$brandName = $this->fm->validation($brandName);
  		$brandName = mysqli_real_escape_string($this->db->link, $brandName);

  		if(empty($brandName)){
  			$brandmsg = "<span class='error'>Brand Field Must not be empty !</span>";
  			return $brandmsg;
  		}else{
  			$query = "INSERT INTO tbl_brand(brandName)VALUES('$brandName')";
  			$insertbrand = $this->db->insert($query);

  			if($insertbrand){
  				$brandmsg = "<span class='success'>Brand Inserted Successfully! </span>";
  				return $brandmsg;

  			}else{
  				$brandmsg = "<span class='error'>Brand Not Inserted ! </span>";
  				return $brandmsg;
  			}


  		}

  	}

  		public function getAllbrand(){
  			$query = "SELECT * FROM tbl_brand ORDER BY brandId DESC";
  			$getBrand = $this->db->select($query);
  			return $getBrand;
  		}

  	

  		public function getbrandByid($brandid){
  			$query = "SELECT * FROM tbl_brand WHERE brandId = '$brandid' ";
  			$result = $this->db->select($query);
  			return $result;
  		}

  		public function updateBrand($brandName, $brandid){
  			$brandName = mysqli_real_escape_string($this->db->link, $brandName);
  			$brandid = mysqli_real_escape_string($this->db->link, $brandid);

  			if(empty($brandName)){
  				$brandmsg = "<span class= 'error'>Brand Field Must Not Be Empty ! </span>";
  				return $brandmsg;
  			}else{
  				$query = "UPDATE tbl_brand SET brandName = '$brandName' WHERE brandId = '$brandid' ";
  				$brandresult = $this->db->update($query);

  				if($brandresult){
  					$brandmsg = "<span class= 'success'>Brand Updated Successfully ! </span>";
  					return $brandmsg;
  				}else{
                    $brandmsg = "<span class= 'error'>Brand Not Updated! </span>";
  					return $brandmsg;
  				}
  			}
  		}

  		public function branddelById($id){
  			$id = mysqli_real_escape_string($this->db->link, $id);

  			$query = "DELETE FROM tbl_brand WHERE brandId = '$id'";
  			$getDelbrand = $this->db->delete($query);
  			if($getDelbrand){
  				$brandmsg = "<span class = 'success'>Brand Deleted Successfully ! </span>";
  				return $brandmsg;
  			}else{
  				$brandmsg = "<span class = 'error'>Brand Not Deleted Successfully ! </span>";
  				return $brandmsg;
  			}

  		}



  	

  }

?>