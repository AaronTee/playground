<?php
  session_start();
  
  // headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  // get post data
  $req_phone = $_POST["phone"];
  $req_verify = $_POST["verify"];
  $req_verifyTac = $_POST["verifytac"];
  $req_password = $_POST["password"];
  $req_confirmPassword = $_POST["confirmpassword"];

  // Verify Code
  $valid = true;

  // Validate post data
  $valid &= isset($req_phone);
  $valid &= isset($req_verify) && (string)$_SESSION["verifyCode"] == (string)$req_verify;
  $valid &= isset($req_verifyTac) && (string)$req_verifyTac == "123456";
  $valid &= isset($req_password);
  $valid &= isset($req_confirmPassword) && $req_password == $req_confirmPassword;

  if (!$valid) {
    http_response_code(401);

    // To add more error checking, right now only return false submit state.
    header('Location: '.'../index.php?fromInvalidSubmitState=true');
  }
  else
  {
    http_response_code(200);
    echo 'Valid data! Successfully registered.'."\n";
    echo '数据正确，成功申请账号.'."\n";
    echo 'Phone Number: '.$req_phone."\n";
    echo 'Verify Code: '.$req_verify."\n";
    echo 'Verify Code (Session): '.(string)$_SESSION["verifyCode"]."\n";
    echo 'Verify TAC: '.$req_verifyTac."\n";
    echo 'Password: '.$req_password."\n";
    echo 'Confirm Password: '.$req_confirmPassword."\n";
  }
?>