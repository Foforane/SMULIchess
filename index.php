<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMU</title>
    <!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
    <h1>SMU Lichess Management System</h1>
    <p>This list is sorted from best going down, The best player is selected using the Blitz rating, as many serious games are played in blitz!</p>
  
    <div class="table-responsive">
 <table class="table table-hover filterTable">
  <thead>

    <tr>
     
      <th scope="col">Surname</th>
      <th scope="col">Name</th>
      <th scope="col">Blitz</th>
      <th scope="col">Bullet</th>
      <th scope="col">Rapid</th>
      <th scope="col">Phone Number</th>
      <th scope="col">Username</th>

    </tr>
  </thead>
  <tbody>
<?php
include "DB.php";
$sql = "SELECT * FROM details";

$result = $conn->query($sql);
$users = [];
if($result->num_rows>0){
    while($row = $result->fetch_assoc()) {
    array_push($users,$row);
    }
    
}
$conn->close();

$ch = curl_init();
foreach($users as $user){
    
    $api_url = "https://lichess.org/api/user/".$user['username'];

curl_setopt($ch,CURLOPT_URL,$api_url);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

$res = curl_exec($ch);


$res = json_decode($res);
$Blitz = $res->perfs->blitz->rating;
$bullet = $res->perfs->bullet->rating;
$rapid = $res->perfs->rapid->rating;
?>



   
   
  <tr>
<td><?php echo $user['surname']; ?></td>
<td><?php echo $user['name']; ?></td>
<td><?php echo $Blitz; ?></td>
<td><?php echo $bullet; ?></td>
<td><?php echo $rapid; ?></td>
<td><?php echo $user['number']; ?></td>
<td><?php echo $user['username']; ?></td>
</tr>
  


 
 


<?php }
curl_close($ch);

?>
  </tbody>
</table>
</div>

<script>
  
      var filterTable, rows, sorted, i, x, y, sortFlag;
      filterTable = document.querySelector(".filterTable");
      sorted = true;
      while (sorted) {
         sorted = false;
         rows = filterTable.rows;
         for (i = 1; i < rows.length - 1; i++) {
            sortFlag = false;
            x = rows[i].getElementsByTagName("TD")[2];
            y = rows[i + 1].getElementsByTagName("TD")[2];
            if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
               sortFlag = true;
               break;
            }
         }
         if (sortFlag) {
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            sorted = true;
         }
      }
   
</script>
</body>
</html>
