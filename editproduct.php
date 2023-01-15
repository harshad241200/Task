<?php
require 'database.php';
$conn = new mysqli("localhost", "root", "", "product");

if(isset($_POST['submit']))
{
 $id=$_GET['id'];
 $productname = $_POST['productname'];
 $sku = $_POST['sku'];
 $price = $_POST['price'];
 $size = $_POST['size'];
 $pic = $_FILES['photo']['name'];
 $folder = "upload/".$pic;
 move_uploaded_file($_FILES['photo']['tmp_name'],$folder);
 
 $res= new Database();
//  $res=$conn->edit('prolist',['id'=>$id,'productname'=>$productname,'sku'=>$sku,'price'=>$price ,'size'=>$size ,'image'=>$folder]);
 $res->edit('prolist',$id,$productname,$sku,$price, $size, $folder);
if ($res == true) {
 header('location:home.php');
}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
    <title>Blogspot</title>

    <style>
        .body{
            margin:0px;
            color:white;
            font-family: Arial;
        }

        .bg-custom-2 {
            background-image: linear-gradient(15deg, #71C5EE 0%, #025091 100%);
        }

        .header{
            margin:0px;
            background:#333;
            padding: 20px;

            display:flex;
            justify-content:space-between;
            align-items: center;
        }

        a{
            color: #f5f2f4;
            margin:10px;
            text-decoration: none;
            font-family: Arial, Helvetica, sans-serif;
        }

        .active{
            color:#04Ae8f;
        }

        /* -----------------------DROPDOWN-------------------------- */
        .nav-item .dropdown {
          position: relative;
          display: inline-block;
        }

        .dropdown-menu {
          display: none;
          position: absolute;
          background-color: #f9f9f9;
          min-width: 160px;
          box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
          padding: 12px 16px;
          z-index: 1;
        }
       
        /* ----------------------ROUNDED CIRCLE---------------------- */
        .dropdown:hover .dropdown-menu {
          display: block;
        }


        .dropdown-img {
          position: relative;
          display: inline-block;
        }
        .rounded-circle {
          border-radius: 50%;
          width: 2.5em;
          height: 2.5em;
          position: center;
          overflow:hidden;
        }

        .dropdown-img-menu{
          display: none;
          position: absolute;
          /* background-color: #f9f9f9; */
          min-width: 160px;
          box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
          padding: 12px 16px;
          z-index: 1;
        }
    
        .dropdown-img:hover .dropdown-img-menu {
          display:block;
        }




        /*form*/
 form{
    margin-top:20px;
    width: 800px;
    box-shadow: 0 0 40px rgba(8,7,16,0.6);
    padding: 50px 35px;
}
form *{
    font-family: 'Poppins',sans-serif;
    color: #190a05;
    letter-spacing: 0.5px;
    border: 2px solid rgba(255,255,255,0.1);
}
form h3{
    font-size: 32px;
    font-weight: 500;
    line-height: 42px;
    text-align: center;
}

label{
    display: block;
    margin-top: 30px;
    font-size: 20px;
    font-weight: 500;
}
.input{
    display: block;
    height: 50px;
    width: 100%;
    background-color: rgba(255,255,255,0.07);
    border-radius: 3px;
    border-color:black;
    padding: 0 10px;
    margin-top: 8px;
    font-size: 14px;
    font-weight: 300;
}
::placeholder{
    color: #1C1919;
}
button{
    position:center;
    margin-top: 50px;
    margin-bottom: 40px;
    width: 100%;
    background-color: #025091;
    padding: 20px 0;
    font-size: 22px;
    font-weight: 400;
    color:#e5e5e5;
    border-radius: 8px;
    cursor: pointer;
}
</style>
</head>

<body>
<nav class="navbar navbar-expand-lg bg-custom-2 bg-primary">
  <a class="navbar-brand" href="#">PRODUCT</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto ">
      <li class="nav-item active">
        <a class="nav-link" href="home.php">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="productform.php">Add Product<span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
          Dropdown
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li>
      </ul>
  </div>
<!-- <div class="pull-right">
    <ul class="nav pull-right">
        <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Welcome <?php echo $user["username"]; ?></a>
        <ul class="dropdown-menu">
            <li><a href="logout.php">Logout</a></li>
        </ul>
        </li>
    </ul>
</div>  -->
</nav>

<div class="container">
    <form action="" id="myTable" method="post" enctype="multipart/form-data" autocomplete="off">
        <h3>Edit Product</h3>

        <?php
        $id = $_GET['id'];
        $rows = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM prolist WHERE id = $id"));
        ?>


        <input type="hidden" id="id" value="<?php echo $rows['id'];?>">

        <label for="productname">Product Name</label>
        <input type="text" class="input" placeholder="Product Name" id="productname" name="productname" value="<?php echo $rows['productname'];?>">

        <label for="sku">SKU</label>
        <input type="text" class="input" placeholder="Product-Code" id="sku" name="sku" value="<?php echo $rows['sku'];?>">

        <div class="row">
          <div class="col-md-6">
        <label for="size">Size</label>
        <input type="number" class="input" placeholder="Enter Size" id="size" name="size" value="<?php echo $rows['size'];?>">
          </div>
          <div class="col-md-6">
        <label for="Price">Price</label>
        <input type="text" class="input" placeholder="Price" id="price" name="price" value="<?php echo $rows['price'];?>">
          </div>
        </div>

        <label for="image">Product Image:</label>
        <input type="file" name="photo" id="image" value="<?php echo $rows['image'];?>">
        <br><br>

        <!-- <div class="col-12 form-group">
            <input type="submit" class="btn" name="submit">
        </div> -->
        <h6 class="text text-center">OR</h6>
        <br><br>

        <div Class="input-row">
		    <label>Coose your CSV file</label> 
        <input type="file" name="file" id="file" name="file" class="file" accept=".csv,.xls,.xlsx">
	      </div>

        <button type="submit" name="submit">Submit</button>

    </form>
    </div>



<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>    
</body>
</html>