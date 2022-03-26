<?php
  $filepath = realpath(dirname(__FILE__));
  include_once ($filepath."/../lib/Database.php");
  include_once ($filepath."/../helper/Format.php");
?>

<?php
   Class Cart{
   	 private $db;
  	 private $fm;

   	 public function __construct(){
   	 	$this->db = new Database();
   	 	$this->fm = new Format();
   	 }

     public function addToCart($quantity,$id){
      $quantity = $this->fm->validation($quantity);
      $quantity = mysqli_real_escape_string($this->db->link, $quantity);
      $productId = mysqli_real_escape_string($this->db->link, $id);
      $sessionId = session_id();

      $squery = "SELECT * FROM tbl_product WHERE productId ='$productId' ";
      $result = $this->db->select($squery)->fetch_assoc();

      $productName = $result['productName'];
      $price = $result['price'];
      $image = $result['image'];

      $checkQuery = "SELECT * FROM tbl_cart WHERE productId = '$productId' AND sessionId = '$sessionId'";
      $getPro = $this->db->select($checkQuery);

      if($getPro){
        $msg = "Product Already Added! ";
        return $msg;
      }else{

      $query = "INSERT INTO tbl_cart(sessionId,productId,productName,price,quantity,image)VALUES('$sessionId','$productId ','$productName','$price','$quantity ','$image')";

        $inserted_row = $this->db->insert($query);
        if($inserted_row){
            header("Location:cart.php");

        }else{
             header("Location:404.php"); 
        }
      }

     }

     public function getCartPro(){
        $sessionId = session_id();
        $query = "SELECT * FROM tbl_cart WHERE sessionId = '$sessionId' ";
        $result = $this->db->select($query);
        return $result;

     }

     public function updateCartQuantity($cartId,$quantity){
     
      $cartId = mysqli_real_escape_string($this->db->link, $cartId);
      $quantity = mysqli_real_escape_string($this->db->link, $quantity);

      $query = "UPDATE tbl_cart SET quantity = '$quantity' WHERE cartId = '$cartId' ";
        $update_row = $this->db->update($query);

        if($update_row){
         header("Location:cart.php");
        }else{
          $quantitymsg = "<span class='error'>Quantity Not Updated !</span>";
          return $quantitymsg;
        }

     }

     public function delCartProduct($delcartId){
        $query = "DELETE FROM  tbl_cart WHERE cartId = '$delcartId'";

        $result = $this->db->delete($query);
        if($result){
        echo "<script>window.location = 'cart.php';</script>";
        }else{
          $delmsg = "<span class='error'>Cart Product Is Not Deleted !</span>";
          return $delmsg;
        }

     }

     public function checkCartTable(){
        $sessionId = session_id();
        $query = "SELECT * FROM tbl_cart WHERE sessionId = '$sessionId' ";
        $result = $this->db->select($query);
        return $result;
     }

     public function delCustomerCart(){
        $sessionId = session_id();
        $query = "DELETE FROM tbl_cart WHERE sessionId = '$sessionId' ";
        $this->db->delete($query);
     }

     public function insertOrderProduct($cusId){
        $sessionId = session_id();
        $query = "SELECT * FROM tbl_cart WHERE sessionId = '$sessionId' ";
        $getPro = $this->db->select($query);
        if($getPro){
          while($result = $getPro->fetch_assoc()){
            $productId = $result['productId'];
            $productName = $result['productName'];
            $quantity = $result['quantity'];
            $price = $result['price'] * $quantity;
            
            $image = $result['image'];

            
          $query = "INSERT INTO tbl_order(cusId,productId,productName,price,quantity,image)VALUES('$cusId','$productId ','$productName','$price','$quantity ','$image')";

              $inserted_row = $this->db->insert($query);
              
           }

          }
        }

      public function payableAmount($cusId){
        $query = "SELECT * FROM tbl_order WHERE cusId = '$cusId' AND date=now()";
        $result = $this->db->select($query);
        return $result;
        
      }

      public function getOrderList($cusId){
        $query = "SELECT * FROM tbl_order WHERE cusId = '$cusId' ORDER BY date DESC";
        $result = $this->db->select($query);
        return $result;
      }

      public function checkOrderDet($cusId){

        $query = "SELECT * FROM tbl_order WHERE cusId = '$cusId' ";
        $result = $this->db->select($query);
        return $result;
      }

      public function getAllOrderdetails(){
        $query = "SELECT * FROM tbl_order ORDER BY date ";
        $result = $this->db->select($query);
        return $result;
      }

      public function  orderShifted($cusId,$date,$price){
        $cusId = $this->fm->validation($cusId);
        $date  = $this->fm->validation($date);
        $price = $this->fm->validation($price);

        $cusId = mysqli_real_escape_string($this->db->link, $cusId);
        $date  = mysqli_real_escape_string($this->db->link, $date);
        $price = mysqli_real_escape_string($this->db->link, $price);

        $query = "UPDATE  tbl_order SET status = '1' WHERE cusId = '$cusId' AND date= '$date' AND price = ' $price' ";
              

              $updated_row = $this->db->update($query);
              if($updated_row){
                $msg = "<span class='success'>Updated Successfully! </span>";
                  return $msg;

              }else{
                $msg = "<span class='error'> Not Updated ! </span>";
                  return $msg;
              }
      }

      public function delorderShifted($cusId,$date,$price){
        $query = "DELETE FROM  tbl_order WHERE cusId = '$cusId' AND date= '$date' AND price = ' $price' ";

        $getDel = $this->db->delete($query);
        if($getDel){
          $delmsg = "<span class='success'> Deleted Successfully !</span>";
          return $delmsg;
        }else{
          $delmsg = "<span class='error'> Not Deleted !</span>";
          return $delmsg;
        }
      }

      public function cnfrmOrderShifted($cusId,$date,$price){
        $cusId = $this->fm->validation($cusId);
        $date  = $this->fm->validation($date);
        $price = $this->fm->validation($price);

        $cusId = mysqli_real_escape_string($this->db->link, $cusId);
        $date  = mysqli_real_escape_string($this->db->link, $date);
        $price = mysqli_real_escape_string($this->db->link, $price);

        $query = "UPDATE  tbl_order SET status = '2' WHERE cusId = '$cusId' AND date= '$date' AND price = ' $price' ";
              

              $updated_row = $this->db->update($query);
              if($updated_row){
                $msg = "<span class='success'>Updated Successfully! </span>";
                  return $msg;

              }else{
                $msg = "<span class='error'> Not Updated ! </span>";
                  return $msg;
              }
      }
     
   }
?>