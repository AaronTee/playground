<?php
  namespace app\utils;
  include "{$_SERVER['DOCUMENT_ROOT']}/utils/AntiBotHelper.php"; 

  session_start();

  $helper = new AntiBotHelper();
  $randCode = $helper->generateUniqueCode();
  $_SESSION["verifyCode"] = $randCode;
  $uri = $helper->getImageStreamData($randCode);

  header('Content-Type: application/json');
  echo json_encode($uri);
?>