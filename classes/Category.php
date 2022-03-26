<?php
  $filepath = realpath(dirname(__FILE__));
  include_once ($filepath."/../lib/Database.php");
  include_once ($filepath."/../helper/Format.php");
?>

<?php
  Class Category{
  	private $db;
  	private $fm;

  	public function __construct(){
  		$this->db = new Database();
  		$this->fm = new Format();
  	}

  	public function insertCat($catName){
  		$catName = $this->fm->validation($catName);
  		$catName = mysqli_real_escape_string($this->db->link, $catName);

  		if(empty($catName)){
  			$catmsg = "<span class='error'>Category Field Must not be empty !</span>";
  			return $catmsg;
  		}else{
  			$query = "INSERT INTO tbl_category(catName)VALUES('$catName')";
  			$insertcat = $this->db->insert($query);

  			if($insertcat){
  				$catmsg = "<span class='success'>Category Inserted Successfully! </span>";
  				return $catmsg;

  			}else{
  				$catmsg = "<span class='error'>Category Not Inserted ! </span>";
  				return $catmsg;
  			}


  		}

  	}

  	public function getAllcat(){
  		$query = "SELECT * FROM tbl_category ORDER BY catId DESC ";
  		$result = $this->db->select($query);
  		return $result;
  	}

  	public function getcatByid($id){
  		$query = "SELECT * FROM tbl_category WHERE catId = '$id' ";
  		$result = $this->db->select($query);
  		return $result;
  	}

  	public function updateCat($catName, $id){
  		$catName = $this->fm->validation($catName);
  		$catName = mysqli_real_escape_string($this->db->link, $catName);
  		$id = mysqli_real_escape_string($this->db->link, $id);

  		if(empty($catName)){
  			$catmsg = "<span class='error'>Category Field Must Not Be Empty !</span>";
  			return $catmsg;
	  	}else{
	  		$query = "UPDATE tbl_category SET catName = '$catName' WHERE catId = '$id' ";
	  		$update_row = $this->db->update($query);

	  		if($update_row){
	  			$catmsg = "<span class='success'>Category Updated  Successfully!</span>";
	  			return $catmsg;
	  		}else{
	  			$catmsg = "<span class='error'>Category Not Updated !</span>";
	  			return $catmsg;
	  		}
  	   }

  	}

		public function catdelById($id){
			$id = mysqli_real_escape_string($this->db->link, $id);

			$query = "DELETE FROM  tbl_category WHERE catId = '$id'";

			$getDel = $this->db->delete($query);
			if($getDel){
				$delmsg = "<span class='success'>Category Deleted Successfully !</span>";
				return $delmsg;
			}else{
                $delmsg = "<span class='error'>Category Is Not Deleted !</span>";
				return $delmsg;
			}

		}


  }

?>