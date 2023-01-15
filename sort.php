<?php  
 //sort.php  
 $conn = mysqli_connect("localhost", "root", "", "product");
 $limit = 3;

 $output = '';  
 $order = $_POST["order"];  
 if($order == 'desc')  
 {  
    $order = 'asc';  
 }  
 else  
 {  
    $order = 'desc';  
 }

 if (!isset ($_GET['page']) ) {  
$page_number = 1;  

} else {  
$page_number = $_GET['page'];  

}
 
 $query = "SELECT * FROM prolist ORDER BY ".$_POST["column_name"]." ".$_POST["order"]."";  
 $result = mysqli_query($conn, $query);  

 $total_rows = mysqli_num_rows($result);
 $total_pages = ceil ($total_rows / $limit);
 $initial_page = ($page_number-1) * $limit;
 $getQuery = "SELECT *FROM prolist LIMIT " . $initial_page . ',' . $limit;
  

 $output .= '  
 <table class="table table-striped" style=""> 

      <tr>  
           <th><a class="column_sort" id="id" data-order="'.$order.'" href="#">ID</a></th>  
           <th><a class="column_sort" id="productname" data-order="'.$order.'" href="#">PRODUCT NAME</a></th>  
           <th><a class="column_sort" id="sku" data-order="'.$order.'" href="#">SKU</a></th> 
           <th><a class="column_sort" id="size" data-order="'.$order.'" href="#">SIZE</a></th> 
           <th><a class="column_sort" id="price" data-order="'.$order.'" href="#">PRICE</a></th>    
           <th><a class="column_sort" id="image" data-order="'.$order.'" href="#">IMAGE</a></th>
           <th>ACTION</th>
      </tr>  
 ';  
 while($row = mysqli_fetch_array($result))  
 {  
      $output .= ' 
      
      <tr>  
           <td>' . $row["id"] . '</td>  
           <td>' . $row["productname"] . '</td>  
           <td>' . $row["sku"] . '</td>  
           <td>' . $row["price"] . '</td>  
           <td>' . $row["size"] . '</td>  
          <td>' . $row["image"] . '</td>
          <td>
      </tr>  
      ';  
 }  
 $output .= '</table>';  
 echo $output;  
 ?> 
</table>
<!-- <?php 
  for($page_number = 1; $page_number<= $total_pages; $page_number++) {  

  echo '<a href = "home.php?page=' . $page_number . '">' . $page_number . ' </a>';  
}
?> -->
