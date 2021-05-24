<?php
include 'connect.php';
session_start();


if(!empty($_REQUEST['code'])){
	$url = 'https://accounts.google.com/o/oauth2/token';			
	$curlPost = 'client_id='.GOOGLE_ID.'&redirect_uri='.urlencode(GOOGLE_REDIRECT_URL).'&client_secret='.GOOGLE_SECRET.'&code='.$_REQUEST['code'].'&grant_type=authorization_code';
	$ch = curl_init();		
	curl_setopt($ch, CURLOPT_URL, $url);		
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);		
	curl_setopt($ch, CURLOPT_POST, 1);		
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);	
	$data = json_decode(curl_exec($ch), true);
	if(!empty($data['access_token'])){
		$url = 'https://www.googleapis.com/oauth2/v2/userinfo?fields=email,verified_email';	
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer '.$data['access_token']]);
		$data2 = json_decode(curl_exec($ch), true);
		if(!empty($data2['email']) and !empty($data2['verified_email'])){
			$_SESSION['logged_in'] = true;
			$_SESSION['email'] = $data2['email'];
			
		}
	}
}

if(empty($_SESSION['logged_in'])){
	$google_login_url = 'https://accounts.google.com/o/oauth2/v2/auth?scope=' . urlencode('https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/plus.me') . '&redirect_uri=' . urlencode(GOOGLE_REDIRECT_URL) . '&response_type=code&client_id=' . GOOGLE_ID . '&access_type=online';
}
if(isset($_SESSION['fname'])){
	header('Location: loginon.php');
}
if(isset($_SESSION['email'])){
	$email = $_SESSION['email'];
	$query = $pdo->prepare("SELECT * FROM tab1 WHERE lname = '$email'");
	$query ->execute();
	$fetch = $query->fetch(PDO::FETCH_ASSOC);
	if ($fetch['id']) {
		$_SESSION['id'] = $fetch['id'];
		header('Location: loginon.php');	
	}
	if (!$fetch['id']) {
		$tab = explode("@", $email);
		$googlename = $tab[0]; 
		$ver = 1;
		$query = $pdo->prepare("INSERT INTO tab1 (fname, lname, verified) VALUES (:fname, :lname, :verified)");
		$query->bindParam(':fname', $googlename);
        $query->bindParam(':lname', $email);
		$query->bindParam(':verified', $ver);
		if($query->execute()) {
			$call = $pdo->prepare("SELECT * FROM tab1 WHERE lname = '$email'");
			$call ->execute();
			$fetch = $call->fetch(PDO::FETCH_ASSOC);
			$_SESSION['id'] = $fetch['id'];
			header('Location: loginon.php');
		}
	}
}
?>
<!DOCTYPE html>
<html lang="pl">
  <head>
    <meta charset="utf-8" />
    <title>Login</title>
    <meta name="description" content="Flags" />
    <meta http-equiv="X-Ua-Compatible" content="IE=edge,chrome=1" />
    <link rel="stylesheet" href="style.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  </head>

  <body>
   
        <?php
		if(empty($_SESSION['logged_in'])){
	?>
   <div class="start">
    <div id="demo">
      <p>Register</p>
      <form method="post" enctype="multipart/form-data">
      
        <input type="text" id="fname" name="fname" placeholder="Nick"><br><br>
     
        <input type="email" id="lname" name="lname" placeholder="Email"><br><br>
       
        <input type="password" id="pass" name="pass" placeholder="Password"> <br><br>

        

        <input type='file' id="image" name='file' /><br><br>

        <button id="send">Submit</button><br><br>
      </form> 
     <!--<button id="random">Generate password</button><br><br>--> 
    </div>
    <div id="log">
        <p>LogIn</p>
        <input type="text" id="logNick" name="fname" placeholder="Nick"><br><br>
        <input type="password" id="logPass" name="pass" placeholder="Password"><br><br>
        <button id="login">LogIn</button>
        </div>
  </div>
			<a href="<?= $google_login_url ?>"><img src="img/google.png"></a>
	<?php
		}
	?>
  <script src="ajax.js"></script>
 
  </body>
</html>