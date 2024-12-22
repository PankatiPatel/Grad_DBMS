<?php 
 include("dbconfig.php"); 

$sql = "SELECT vendor_id, name, latitude, Longitude FROM CPS5740.VENDOR";


$result = mysqli_query($conn, $sql); 
$numRow = mysqli_num_rows($result); 

$result_arr = array(); 
while($row = mysqli_fetch_assoc($result)){
   
    $result_arr[] = $row; 
}

echo json_encode($result_arr);

mysqli_free_result($result);

mysqli_close($conn);

?>
