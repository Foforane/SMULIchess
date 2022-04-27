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
<img src="logo.png" height="100" alt="Sample photo">
    <h1>SMU Lichess Rank</h1>
    <p>This list is sorted from best going down, The best player is selected using the Blitz rating, as many serious games are played in blitz!</p>
    <h2>Official Practice times</h2>
    <h3>Venue : Sports Comm</h3>
    <p>Thursday 16h30 - 18h00</p>
    <p>Friday 16h30 - 18h00</p>
    <div class="table-responsive">
 <table class="table table-hover filterTable">
  <thead>

    <tr>
     
      <th scope="col">Surname</th>
      <th scope="col">Name</th>
      <th scope="col">Blitz</th>
      <th scope="col">Bullet</th>
      <th scope="col">Rapid</th>
      <th scope ="col">Section</th>
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
$bestplayerinfo = "";
$femaleInfo = "";
if($result->num_rows>0){
    while($row = $result->fetch_assoc()) {
    array_push($users,$row);
    }
    
}
$conn->close();
$risk = [];
$games = 0;
$bestBlitz = 0;
$bestFemale = 0;
$bestuserName ="";
$bestFemaleuser = "";
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
if($Blitz <= 1400){
    $riskplayer = $user['surname']." ".$user['name']." with a blitz rating of ".$Blitz;
    array_push($risk,$riskplayer);
}
if($user['section'] == "Female"){
  if($bestFemale < $Blitz){
  $bestFemale = $Blitz;
  $games = $res->perfs->blitz->games;
  $bestFemaleuser = $user['username'];
  $femaleInfo = $user['surname']." ".$user['name']." with a blitz rating of ".$Blitz." and ".$games." blitz  games played."
  ?>
  
 <?php }
}
if($bestBlitz < $Blitz){
$bestBlitz = $Blitz;
$games = $res->perfs->blitz->games;
$bestuserName =$user['username'];
$bestplayerinfo = $user['surname']." ".$user['name']." with a blitz rating of ".$Blitz." and ".$games." blitz games played. 
if you want to Dethrone ".$user['name']." you can request a ";
}
?>



   
   
  <tr>
<td><?php echo $user['surname']; ?></td>
<td><?php echo $user['name']; ?></td>
<td><?php echo $Blitz; ?></td>
<td><?php echo $bullet; ?></td>
<td><?php echo $rapid; ?></td>
<td><?php echo $user['section']?></td>
<td><?php echo "0". $user['number']; ?></td>
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
            x = rows[i].getElementsByTagName("TD")[2].innerHTML;
            y = rows[i + 1].getElementsByTagName("TD")[2].innerHTML;
            x = Number(x);
            y = Number(y);
            if (x < y) {
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

<h2>Best:</h2>
 <p><?php echo $bestplayerinfo;?> 
 <a href = "https://lichess.org/@/<?php echo $bestuserName;?>" class = "link-primary ">Challange</a>
</p>

  
<h2>The best female player is:</h2>
<p><?php echo $femaleInfo;?> you can also 
 <a href = "https://lichess.org/@/<?php echo $bestFemaleuser;?>" class = "link-primary ">Challange</a> her if you want to personally remove her from the Throne.
</p>
<?php
if(!empty($risk)){
  echo "<h2>Players who are in the critical area (blitz <= 1400):</h2>";

foreach($risk as $r){
  echo "<p>".$r."</p><br>";
}
}
?>
<a href = "https://lichess.org/team/team-smu" class = "btn btn-primary">Join SMU Team on Lichess</a>
<p>Disclaimer: This list will not be used in any selections for over the board activities. It remains strictly Lichess.</p>
</body>
</html>
