<?php
	include 'database.php';
	 $conn = new mysqli("localhost", "root", "", "csvdata");
     if(isset($_POST["Import"])){
        
        $filename=$_FILES["file"]["tmp_name"];    
         if($_FILES["file"]["size"] > 0)
         {
            $file = fopen($filename, "r");
			fgetcsv($file);
              while (($getData = fgetcsv($file, 10000, ",")) !== FALSE)
               {
                 $sql = "INSERT into csv (id,productname,sku,price,size,image) 
                       values ('".$getData[0]."','".$getData[1]."','".$getData[2]."','".$getData[3]."','".$getData[4]."','".$getData[5]."')";
                       $result = mysqli_query($conn, $sql);
            if(!isset($result))
            {
              echo "<script type=\"text/javascript\">
                  alert(\"Invalid File:Please Upload CSV File.\");
                  window.location = \"csvform.php\"
                  </script>";    
            }
            else {
                echo "<script type=\"text/javascript\">
                alert(\"CSV File has been successfully Imported.\");
                window.location = \"csvform.php\"
              </script>";
            }
               }
               fclose($file);  
         }
      }   
	    function get_all_records(){
        $conn = new mysqli("localhost", "root", "", "csvdata");
        $Sql = "SELECT * FROM csv";
        $result = mysqli_query($conn, $Sql);  
        if (mysqli_num_rows($result) > 0) {
         echo "<div class='table-responsive'><table id='myTable' class='table table-striped table-bordered'>
                 <thead><tr><th>ID</th>
                              <th>PRODUCT NAME</th>
                              <th>SKU</th>
                              <th>PRICE</th>
                              <th>SIZE</th>
                              <th>IMAGE</th>
                            </tr></thead><tbody>";
         while($row = mysqli_fetch_assoc($result)) {
             echo "<tr><td>" . $row['id']."</td>
                       <td>" . $row['productname']."</td>
                       <td>" . $row['sku']."</td>
                       <td>" . $row['price']."</td>
                       <td>" . $row['size']."</td>
                       <td>" . $row['image']."</td></tr>";        
         }
        
         echo "</tbody></table></div>";
         
    } else {
         echo "No Records Found..";
    }
    }
	     if(isset($_POST["Export"])){
         
          header('Content-Type: text/csv; charset=utf-8');  
          header('Content-Disposition: attachment; filename=data.csv');  
          $output = fopen("php://output", "w");  
		 
          fputcsv($output, array('id', 'productname', 'sku', 'price', 'size' , 'image'));  
          $query = "SELECT * from csv ORDER BY id DESC";  
          $result = mysqli_query($conn, $query);  
          while($row = mysqli_fetch_assoc($result))  
          {  
               fputcsv($output, $row);  
          }  
          fclose($output);  
     }  
     ?>