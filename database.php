<?php
session_start();

class Database{
  public $db_host = "localhost";
  public $db_user = "root";
  public $db_pass = "";
  public $db_name = "csvdata";
  public $conn;

  public function __construct(){
  $this->conn = mysqli_connect($this->db_host,$this->db_user,$this->db_pass,$this->db_name);
  }

  public function insert($table,$para=array()){
  $table_columns = implode(',', array_keys($para));
  $table_value = implode("','", $para);
  $sql="INSERT INTO $table($table_columns) VALUES('$table_value')";
  $result = $this->conn->query($sql);
  }

  // public function edit($table,$id,$productname,$sku,$price, $size, $folder)
  // {
  // $res = mysqli_query($this->conn,"UPDATE $table SET id='$id', productname='$productname', sku='$sku', price='$price', size='$size', image='$folder' WHERE id=".$id);
  // return $res;
  // }
 
}

// class Register extends Database{
//   public function registration($username, $email, $password, $confirmpassword){
//     $duplicate = mysqli_query($this->conn, "SELECT * FROM product_data WHERE username = '$username'");
//     if(mysqli_num_rows($duplicate) > 0){
//       return 10;
//       // Username has already taken
//     }
//     else{
//       if($password == $confirmpassword){
//         $query = "INSERT INTO product_data VALUES('', '$username', '$email', '$password')";
//         mysqli_query($this->conn, $query);
//         return 1;
//         // Registration successful
//       }
//       else{
//         return 100;
//         // Password does not match
//       }
//     }
//   }
// }

// class Login extends Database{
//   public $id;
//   public function log($username, $password){
//     $result = mysqli_query($this->conn, "SELECT * FROM product_data WHERE username = '$username'");
//     $row = mysqli_fetch_assoc($result);

//     if(mysqli_num_rows($result) > 0){
//       if($password == $row["password"]){
//         $this->id = $row["id"];
//         return 1;
//         // Login successful
//       }
//       else{
//         return 10;
//         // Wrong password
//       }
//     }
//     else{
//       return 100;
//       // User not registered
//     }
//   }

//   public function idUser(){
//     return $this->id;
//   }
// }

// class Select extends Database{
//   public function selectUserById($id){
//     $result = mysqli_query($this->conn, "SELECT * FROM product_data WHERE id = $id");
//     return mysqli_fetch_assoc($result);
//   }

//   public function fetchdata()
//  {
//  $result=mysqli_query($this->conn,"SELECT * FROM prolist");
//  return $result;
//  }

// }

?>