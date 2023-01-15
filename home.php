<?php
require 'database.php';
$conn = new mysqli("localhost", "root", "", "product");
$limit = 3;

$select = new Select();
if(!empty($_SESSION["id"])){
  $user = $select->selectUserById($_SESSION["id"]);
}
else{
  header("Location: index.php");
} 

if (!isset ($_GET['page']) ) {  
$page_number = 1;  

} else {  
$page_number = $_GET['page'];  

}


//Sorting Asc Desc
// $query = "SELECT * FROM prolist ORDER BY id DESC";  
// $result = mysqli_query($conn, $query);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <!-- <script src="https://www.kryogenix.org/code/browser/sorttable/sorttable.js"></script> -->
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

a {
  color: #343a40;
  margin: 10px;
  text-decoration: none;
  font-family: Arial, Helvetica, sans-serif;
}

.active{
  color:#343a40;
  /* color:#04Ae8f; */
}

/* -----------------------DROPDOWN-------------------------- */
.nav-item .dropdown {
  position: relative;
  display: inline-block;
}

.dropdown-menu {
  display: none;
  position: absolute;
  background-color: #dee2e6; 
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  padding: 12px 16px;
  z-index: 1;
}

.dropdown:hover .dropdown-menu {
  display: block;
}

button{
position:center;
margin-top:0px;
margin-bottom: 20px;
width:35%;
background-color: #2a8ab9;
color:#e5e5e5;
border-radius: 10px;
cursor: pointer;
}

.table td, .table th {
padding: 0.75rem;
vertical-align: middle;
border-top: 1px solid #dee2e6;
}

#table-data{
padding: 15px;
min-height: 500px;
}
#table-data th{
background:#71C5EE;
color: #fff;
}
#table-data tr:nth-child(odd){
background: #ecf0f1;
}


.wrapper{
  /* position: fixed; */
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}

.wrap{
  display: block;
  width: 200px;
  height: 40px;
  line-height: 40px;
  font-size: 18px;
  font-family: sans-serif;
  text-decoration: none;
  color: #333;
  border: 2px solid #333;
  letter-spacing: 2px;
  text-align: center;
  position: relative;
  transition: all .35s;
}

.wrap span{
  position: relative;
  z-index: 2;
}

.wrap:after{
  position: absolute;
  content: "";
  top: 0;
  left: 0;
  width: 0;
  height: 100%;
  background: #ff003b;
  transition: all .35s;
}

.wrap:hover{
  color: #fff;
}

.wrap:hover:after{
  width: 100%;
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
          <a class="dropdown-item" href="csvform.php">IMPORT CSV</a>
          <a class="dropdown-item" href="#">Another action</a>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li>
      </ul>
  </div>
<div class="pull-right">
    <ul class="nav pull-right">
        <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Welcome <?php echo $user["username"]; ?></a>
        <ul class="dropdown-menu">
            <li><a href="logout.php">Logout</a></li>
        </ul>
        </li>
    </ul>
</div> 
</nav>
  <div class="container" id="table-data">
     <table class="table table-striped sortable" style="width:100%">
        <thead>
            <tr>
                <th><a class="column_sort" id="id" data-order="desc" href="#">ID</a></th>
                <th><div class="input-group rounded">
  <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
  <span class="input-group-text border-0" id="search-addon">
    <i class="fas fa-search"></i>
  </span>
</div><a class="column_sort" id="productname" data-order="desc" href="#">PRODUCT NAME</a></th>
                <th><a class="column_sort" id="sku" data-order="desc" href="#">SKU</a></th>
                <th><a class="column_sort" id="price" data-order="desc" href="#">PRICE</a></th>
                <th><a class="column_sort" id="size" data-order="desc" href="#">SIZE</a></th>
                <th><a class="column_sort" id="image" data-order="desc" href="#">IMAGE</a></th>
                <th>ACTION</th>
            </tr>
        </thead>
        <tbody>

<?php
$getQuery = "SELECT * FROM prolist";  
$result = mysqli_query($conn, $getQuery);  
$total_rows = mysqli_num_rows($result);
$total_pages = ceil ($total_rows / $limit);
$initial_page = ($page_number-1) * $limit;   
$getQuery = "SELECT *FROM prolist LIMIT " . $initial_page . ',' . $limit; 
   

$result = mysqli_query($conn, $getQuery);
while ($row = mysqli_fetch_array($result)) {  
?>

<tr>
<td><?php echo $row['id'];?></td>
<td><?php echo $row["productname"]; ?></td>
<td><?php echo $row["sku"]; ?></td>
<td><?php echo $row["price"]; ?></td>
<td><?php echo $row["size"]; ?></td>
<td><img src="<?php echo $row['image']; ?>" height="100" width="100"></td>
<td>
<!-- <div class="wrapper">
  <a class ="wrap" style="text-decoration:none" href="editproduct.php?id=<?php echo $row['id']; ?>"><span>Edit</span></a> -->
<!-- </div>
<div class="wrapper"> -->
  <!-- <a class ="wrap" style="text-decoration:none" href="deletedata.php?id=<?php echo $row['id']; ?>"><span>Delete</span></a>
</div> -->
<button type="button">
  <a href="editproduct.php?id=<?php echo $row['id']; ?>">Edit</a></button>
<button type="button">
  <a href="deletedata.php?id=<?php echo $row['id']; ?>">Delete</a></button>
</td>
</tr>
  <?php
  }    
?>
  </tbody>
</table>
 </div>

<?php 
  for($page_number = 1; $page_number<= $total_pages; $page_number++) {  
    echo '<a href = "home.php?page=' . $page_number . '">' . $page_number . ' </a>';  
}
?>
<script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script> 
<script>  
 $(document).ready(function(){  
      $(document).on('click', '.column_sort', function(){  
           var column_name = $(this).attr("id");  
           var order = $(this).data("order");  
           var arrow = '';  
          //  glyphicon glyphicon-arrow-up  
          //  glyphicon glyphicon-arrow-down  
           if(order == 'desc')  
           {  
                arrow = '&nbsp;<span class="glyphicon glyphicon-arrow-down"></span>';  
           }  
           else  
           {  
                arrow = '&nbsp;<span class="glyphicon glyphicon-arrow-up"></span>';  
           }  
           $.ajax({  
                url:"sort.php",  
                method:"POST",  
                data:{column_name:column_name, order:order},  
                success:function(data)  
                {  
                     $('#table-data').html(data);  
                     $('#'+column_name+'').append(arrow);  
                }  
           })  
      });  
 });  
 </script>
</body>
</html>