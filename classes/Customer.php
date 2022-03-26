<?php
    $filepath = realpath(dirname(__FILE__));
	include_once ($filepath."/../lib/Database.php");
	include_once ($filepath."/../helper/Format.php");
?>

<?php
   Class Customer{
   	private $db;
   	private $fm;
   	
   	 public function __construct(){
   	 	$this->db = new Database();
   	 	$this->fm = new Format();
   	 }

       public function customerRegistration($data){

         $name     = $this->fm->validation($data['name']);
         $city     = $this->fm->validation($data['city']);
         $zip      = $this->fm->validation($data['zip']);
         $email    = $this->fm->validation($data['email']);
         $address  = $this->fm->validation($data['address']);
         $country  = $this->fm->validation($data['country']);
         $phone    = $this->fm->validation($data['phone']);
         $password = $this->fm->validation($data['password']);
        

         $name     = mysqli_real_escape_string($this->db->link, $data['name']);
         $city     = mysqli_real_escape_string($this->db->link, $data['city']);
         $zip      = mysqli_real_escape_string($this->db->link, $data['zip']);
         $email    = mysqli_real_escape_string($this->db->link, $data['email']);
         $address  = mysqli_real_escape_string($this->db->link, $data['address']);
         $country  = mysqli_real_escape_string($this->db->link, $data['country']);
         $phone    = mysqli_real_escape_string($this->db->link, $data['phone']);
         $password = mysqli_real_escape_string($this->db->link, md5($data['password']));

         if($name == '' || $city == '' || $zip == '' || $email == '' || $address == '' || $country == '' || $phone == '' || $password == ''){
         $msg =  "<span class='error'>Fields Must Not Be Empty ! </span>";
         return $msg;

       }

       $mailQuery = "SELECT * FROM tbl_customer WHERE email = '$email' LIMIT 1 ";
       $mailChk   = $this->db->select($mailQuery);

       if($mailChk != false){
          $msg =  "<span class='error'>Email Already Exist ! </span>";
          return $msg;
       }else{
         $query = "INSERT INTO tbl_customer(name,city,zip,email,address,country,phone,password)VALUES('$name','$city ','$zip','$email','$address ','$country','$phone','$password')";

         $inserted_row = $this->db->insert($query);
         if($inserted_row){
            $msg = "<span class='success'>Customer Data Inserted Successfully! </span>";
             return $msg;

         }else{
            $msg = "<span class='error'>Customer Data Not Inserted ! </span>";
             return $msg;
         }
       }
      }

     public function customerLogin($data){

      $email    = mysqli_real_escape_string($this->db->link, $data['email']);
      $password = mysqli_real_escape_string($this->db->link, md5($data['password']));


      if(empty($email) || empty($password)){
         $msg = "Email and Password Must Not Be Empty! ";
         return $msg;
      }else{
         $query = "SELECT * FROM tbl_customer WHERE email = '$email' AND password = '$password' ";
         $result = $this->db->select($query);

         if($result != false){
            $value = $result->fetch_assoc();

            Session::set('cuslogin', true);
            Session::set('cusId',$value['id']);
            Session::set("cusName", $value['name']);
            header("Location:cart.php");
         }else{
            $msg = "<span class='error'>Email And Password Dosen't Match ! </span>";
            return $msg;
         }
       }
     }

     public function getCustomerData($id){
      $query  = "SELECT * FROM tbl_customer WHERE id = '$id'";
      $result = $this->db->select($query);
      return $result;
     }

     public function updateCustProfile($data,$custid){
       $name     = $this->fm->validation($data['name']);
         $city     = $this->fm->validation($data['city']);
         $zip      = $this->fm->validation($data['zip']);
         $email    = $this->fm->validation($data['email']);
         $address  = $this->fm->validation($data['address']);
         $country  = $this->fm->validation($data['country']);
         $phone    = $this->fm->validation($data['phone']);
        
        
         $name     = mysqli_real_escape_string($this->db->link, $data['name']);
         $city     = mysqli_real_escape_string($this->db->link, $data['city']);
         $zip      = mysqli_real_escape_string($this->db->link, $data['zip']);
         $email    = mysqli_real_escape_string($this->db->link, $data['email']);
         $address  = mysqli_real_escape_string($this->db->link, $data['address']);
         $country  = mysqli_real_escape_string($this->db->link, $data['country']);
         $phone    = mysqli_real_escape_string($this->db->link, $data['phone']);

         if($name == '' || $city == '' || $zip == '' || $email == '' || $address == '' || $country == '' || $phone == '' ){
         $msg =  "<span class='error'>Fields Must Not Be Empty ! </span>";
         return $msg;

       }else{
         $query = "UPDATE tbl_customer SET 
                                   name = '$name',
                                   city = '$city',
                                   zip = '$zip',
                                   email = '$email',
                                   address = '$address',
                                   country = '$country',
                                   phone = '$phone' 
                                   WHERE id = '$custid' ";

         $updated_row = $this->db->update($query);
         if($updated_row){
            $msg = "<span class='success'>Customer Data Update Successfully! </span>";
             return $msg;

         }else{
            $msg = "<span class='error'>Customer Data Not Updated ! </span>";
             return $msg;
         }
       }
      }
    }
   
?>