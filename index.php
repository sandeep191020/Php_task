<?php
session_start();

if(isset($_POST) & !empty($_POST)){
  if($_POST['csrf_token']==$_SESSION['csrf_token']){
    // $messages[] = "CSRF Token Validation Success";
  }else{
    $errors[]= "Problem with CSRF Token Verification";
  }

  $max_time=60*60*24;
  if(isset($_SESSION['scrf_token_time'])){
    $token_time=$_SESSION['csrf_token_time'];
    if($token_time + $max_time >= time ()){
    }else{
      unset($_SESSION['csrf_token']);
      unset($_SESSION['csrf_token_time']);
      echo "CSRF Token Expired";
    }
  }
  if(empty($errors)){
    $messages[] = "Proceed with Next steps";
  }
}

$token=md5(uniqid(rand(),true));
$_SESSION['csrf_token']=$token;
$_SESSION['csrf_token_time']=time();

// print_r($_SESSION);

 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <?php include 'links.php'?>
</head>
<body >
<div class="container">
      <h5 class="mb-0 text-center text-white">Login</h5>      
      <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="POST" class="form-group p-4">
              <input type="hidden" name="csrf_token" value="<?php echo $token; ?>">
              <input class="form-control mt-2" type="text" name="username" required placeholder="username">
              <input class="form-control mt-4" type="password" name="passkey" required placeholder="password">
              <div class="text-center"><button name="submit" class=" button2 " value="submit">Submit</button></div>
          </form>
          <!-- <a href="Display.php">Show Data</a> -->
  </div>

           <table id="log">
        <tr>
            <th>Id</th>
            <th>Username</th>
            <th>Password</th>
        </tr>
        <?php
             $connection = mysqli_connect('localhost','root','','logindb');
             if($connection -> connect_error){
                 die("Connection Failed". $connection -> connect_error);
             }
             $sql="SELECT id, username, passkey from login";
             $result = $connection-> query($sql);
             if(1){
                 while($row = $result -> fetch_assoc()){
                     echo "<tr><td>".$row["id"]."</td><td>".$row["username"]."</td><td>".$row["passkey"]."</td></tr>";
                 }
                 echo "</table>";  
             } 
             else{
                 echo "0 result";
             }

  
        ?>
    </table>
       
</body>
</html>

<?php    
//    include "conn.php";

if($_SERVER['REQUEST_METHOD'] == "POST"){

    $username=$_REQUEST['username'];
    $password = $_REQUEST['passkey'];

    $connection = mysqli_connect('localhost','root','','logindb');

    if($connection) {
       
        $insertquery="insert into login(username, passkey) values('$username','$password')";
        $response = mysqli_query($connection,$insertquery);

     }

}
   
?>
