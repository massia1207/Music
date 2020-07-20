<?php

require_once('../db_config.php');
// require_once('results.php');

$query = "SELECT * FROM notes";

$results = $db_connection->query($query);

$intervals = array('Root','Half', 'Whole', 'Minor 3rd', 'Major 3rd', 'Fourth', 'Tritone','Fifth', 'Minor 6th', 'Major 6th', 'Minor 7th', 'Major 7th');

$keys = array();
foreach ($results as $result){
    array_push($keys, $result['Root']);
  };
$keyIndex = array_rand($keys,1);
$key = $keys[$keyIndex];
$intervalIndex = array_rand($intervals,1);
$interval = $intervals[$intervalIndex];
$correctAnswer = $db_connection->query("SELECT * FROM notes WHERE Root = :$key");

?>

<!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Music Interval Test</title>
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <br>
    <div class="container">
    <h1>Musical Interval Test</h1> 
    <br>   

      <form method="post" >
        <div class="form-group row">
          <label for="id" class="col-sm-2 col-form-label">Root</label>
          <div class="col-sm-3">
            <input type="text" readonly class="form-control" id="root" name="root" value="<?php echo $key; ?>">
          </div>
        </div>
        <div class="form-group row">
          <label for="Interval" class="col-sm-2 col-form-label">Interval</label>
          <div class="col-sm-3">
            <input type="text" readonly class="form-control" id="interval" name="Interval" value="<?php echo $interval;?>">
          </div>
        </div>
        <div class="form-group row">
          <label for="answer" class="col-sm-2 col-form-label">Your Answer</label>
          <div id = "selection" class="col-sm-3 btn">
              <select name = "userAnswer" class="form-control">
              <option value = "" disabled selected>Select</option>
              <?php foreach ($keys as $item){?>
                <option value="<?php echo $item;?>"><?php echo $item;}?></option>
            </select> 
          </div>
        </div>
        <div id = marcus class = "form-group row">
          <button type="submit" id="check" name="check" class="col-sm-5 btn btn-outline-secondary">Check Answer
          <a href=""><i class="fa fa-music"></i></a>
          </button>
        </div>
      
      </form>
    
  </div>

  <!-- NEW SECTION******************************************* -->
<?php
session_start();


if(isset($_POST['clearScore'])){
  session_destroy();
}
if(isset($_POST['check'])){

$root = $_POST['root'];
$interval = $_POST['Interval'];
$userAnswer = $_POST['userAnswer'];

$query2 = "SELECT * FROM notes WHERE Root = :root LIMIT 1";
$result2 = $db_connection->prepare($query2);
$result2->execute([
 'root' => $root  
]);

$result2 = $result2->fetch(PDO::FETCH_ASSOC);

$correctAnswer = $result2[$interval];
?>
 
<div class="container"><br>
  <?php
  if($correctAnswer === $userAnswer){
    $_SESSION['wins']+=1
  ?>
  <div class="alert alert-success row" role = "alert">
    <?php echo "Correct, $userAnswer is the $interval from $root";?>
   
  <?php }else{
      $_SESSION['losses']+=1?>
    <div class="alert alert-danger" role = "alert">
    <?php echo "Sorry, $userAnswer is not the $interval from $root";}?>
    </div>

  <P>
    Correct:
    <?php echo $_SESSION['wins'];?><br>Wrong: <?php echo $_SESSION['losses'];?>
  </P>   
  <form method="POST">
    <!-- <button type="input" id="again" name="again" class="btn">Play Again
      <a href="index.php"><i class="fa fa-music"></i></a>
    </button> -->
    <input type = "submit" name="clearScore" value = "Clear Score" class="btn btn-secondary row"></input>
  </form>
 </div>
<script src="app.js"></script>
</body>
</html>
<?php }?>