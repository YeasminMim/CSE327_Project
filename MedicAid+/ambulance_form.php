<?php
include 'connection.php';

if (!empty($_GET['id'])){
   $dbid =  $_GET['id'];
   $sql = "SELECT full_name, email, contact_number, gender, age, blood_group, division, address FROM donor WHERE donor_id=$dbid";
   $result = mysqli_query($conn,$sql);
   $row = mysqli_fetch_assoc($result);
   $name= $row["full_name"] ;
   $email= $row["email"] ;
   $contact= $row["contact_number"] ;
   $gender= $row["gender"] ;
   $age= $row["age"] ;
   $blood_group= $row["blood_group"] ;
   $division= $row["division"] ;
   $address= $row["address"] ;

   $sql="INSERT INTO plasma(full_name, email, contact_number, gender, age, blood_group, division, address)
  VALUES ('$name','$email','$contact','$gender','$age','$blood_group','$division','$address')";
  mysqli_query($conn, $sql);

  $sql = "UPDATE donor
  SET plasma_status='Active'
  WHERE donor_id='$dbid' ";
  // execute query
  mysqli_query($conn, $sql);

  $sql = "SELECT plasma_id FROM plasma WHERE contact_number='$contact' ";
  $result = mysqli_query($conn,$sql);
  $row = mysqli_fetch_assoc($result);
  $dbp= $row["plasma_id"] ;

  header("Location: thankyou2.php?id=$dbid&p=$dbp");

}


if(isset($_POST['signup'])){

$dbfname = mysqli_real_escape_string($conn, $_POST['fullname']);
$dbemail = mysqli_real_escape_string($conn, $_POST['email']);
$dbcontact = mysqli_real_escape_string($conn, $_POST['contact']);
$dbgender = mysqli_real_escape_string($conn, $_POST['gender']);
$dbage = mysqli_real_escape_string($conn, $_POST['age']);
$dbbgroup = mysqli_real_escape_string($conn, $_POST['bgroup']);
$dbdivision = mysqli_real_escape_string($conn, $_POST['division']);
$dbaddress = mysqli_real_escape_string($conn, $_POST['address']);


$sql = "SELECT email,contact_number FROM plasma";
$result = mysqli_query($conn,$sql);

if (mysqli_num_rows($result) > 0) {
// output data of each row
while($row = mysqli_fetch_assoc($result)) {
$dbbemail= $row["email"];
$dbbcontact= $row["contact_number"];
// Check if the username they entered was correct
if ($dbbemail == $dbemail) {
  echo "<script>
alert('Same User Name Exist! Try Another User Name!');
window.location.href='plasma_form.php';
</script>";
  exit();

  }
  else if($dbbcontact == $dbcontact)
  {
    echo "<script>
  alert('Same Contact Number Exist! Try Another Contact Number!');
  window.location.href='plasma_form.php';
  </script>";
    exit();

  }




}
}
 $sql="INSERT INTO plasma(full_name, email, contact_number, gender, age, blood_group, division, address)
VALUES ('$dbfname','$dbemail','$dbcontact','$dbgender','$dbage','$dbbgroup','$dbdivision','$dbaddress')";
mysqli_query($conn, $sql);

$sql = "SELECT plasma_id
FROM plasma
WHERE email='$dbemail'";
$result = mysqli_query($conn,$sql);
$row = mysqli_fetch_assoc($result);
$dbid= $row["plasma_id"];
header("Location: thankyou.php?id=$dbid");

}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>

    <title>Form | Plasma</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">


    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <!--script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script-->
   </head>
   <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">
   <link rel="stylesheet" href="CSS/signup.css">
   <body>
     <div class="card bg-dark text-white">
         <img class="card-img" src="Image/ambulancesigncover.jpg" alt="Card image">
       <div class="card-img-overlay">
     <article class="card-body mx-auto" style="max-width: 450px;">


<div class="card bg-light">
<article class="card-body mx-auto" style="max-width: 400px;">
  <div class="container-fluid">
    <h2 class="text-center text-dark text-capitalize pt-4">Registration Form </h2>
    <p class="text-center text-dark">Ambulance</p>
	<hr>

  <form action="ambulance_form.php" id="signform" method="POST">
	<div class="form-group input-group">
		<div class="input-group-prepend">
		    <span class="input-group-text"> <i class="fa fa-user"></i> </span>
		 </div>
        <input name="fullname" class="form-control" placeholder="Owner name" type="text" required="">
    </div>
    <div class="form-group input-group">
    	<div class="input-group-prepend">
		    <span class="input-group-text"> <i class="fa fa-phone">  </i> </span>
		</div>
    	<input name="contact" class="form-control" placeholder="Phone number" type="text"  required="">
    </div>
  <div class="form-group input-group">
    <div class="input-group-prepend">
      <span class="input-group-text">  <i class="fa fa-map-marker"></i> </span>
  </div>
  <select name="division" class="form-control"  required="" >
    <option value="" disabled selected>Select Division</option>
    <option>Barishal</option>
    <option>Chittagong</option>
    <option>Dhaka</option>ss
    <option>Mymensingh</option>
    <option>Khulna</option>
    <option>Rajshahi</option>
    <option>Rangpur</option>
    <option>Sylhet</option>

  </select>
</div>
  <div class="form-group input-group">
    <div class="input-group-prepend">
      <span class="input-group-text"> <i class="fa fa-id-card"></i> </span>
  </div>
      <input name="vehicle_no" class="form-control" placeholder="Vehicle Number" type="text" required="">
  </div>
    <div class="form-group input-group">
    	<div class="input-group-prepend">
		    <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
		</div>
        <input name="password"class="form-control" placeholder="Create password" type="password" required=" ">
    </div>

    <div class="form-group">
        <button type="submit" name="signup" form="signform" class="btn btn-primary btn-block"> Register Now  </button>
    </div>
    
</form>
</article>
</div>

</div>



</article>
</nav>
</turna>
</body>
</html>