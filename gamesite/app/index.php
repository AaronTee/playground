<?php
  namespace app;

  $fromInvalidSubmitState = false;
  if (isset($_GET['fromInvalidSubmitState'])){
    $fromInvalidSubmitState = $_GET['fromInvalidSubmitState'];
  }
?>

<!DOCTYPE html>
<html>

<head>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
  <link rel="stylesheet" href="./style/home.css">
</head>

<body style='background: #0e0e0e; overflow-y: scroll'>
  <div class='container' style='width: 500px'>

    <!-- Logo -->
    <img src='./img/logo.png' class='mx-auto d-block' style='width: 55%; height 55%;' />
    <br />
    <img src='./img/title2.png' class='mx-auto d-block' style='width: 30%;' />
    <br />
    <form id="login_form" action="./apis/login.php" method="POST">
      <!-- Phone number -->
      <div class='form-group'>
        <div class="input-group input-group-lg">
          <div class="input-group-prepend">
            <span class='input-group-text'>
              <i class="fas fa-mobile-alt" style="width: 20px; height: 20px"></i>
            </span>
          </div>
          <input id='phonenumber' type="number" class="form-control" placeholder="手机号" name="phone">
        </div>
      </div>
      <!-- Robot Check -->
      <div class='form-group row'>
        <div class='col-8'>
          <div class="input-group input-group-lg">
            <div class="input-group-prepend">
              <span class='input-group-text'>
                <i class="fas fa-shield-alt"></i>
              </span>
            </div>
            <input 
              type="number" 
              id="verify"
              class="form-control" 
              oninput="this.value=this.value.slice(0,4)"
              placeholder="图形验证码"
              name="verify">
          </div>
        </div>
        <div class='col-4'>
          <button id='verifycode' 
            title='点击刷新图形验证码' 
            class='btn btn-success btn-lg btn-block'
          >
            <img src='#'>
          </button>
        </div>
      </div>
      <!-- TAC Code -->
      <div class='form-group row'>
        <div class='col-8'>
          <div class="input-group input-group-lg">
            <div class="input-group-prepend">
              <span class='input-group-text'>
                <i class="fas fa-shield-alt"></i>
              </span>
            </div>
            <input 
              type="number" 
              id="verifytac"
              class="form-control" 
              oninput="this.value=this.value.slice(0,6)"
              placeholder="手机验证码"
              name="verifytac">
          </div>
        </div>
        <div class='col-4'>
          <button id="taccode" class='btn btn-success btn-lg btn-block txt-sm'>获取手机验证码</button>
        </div>
      </div>
      <!-- Password -->
      <div class='form-group'>
        <div class="input-group input-group-lg">
          <div class="input-group-prepend">
            <span class='input-group-text'>
              <i class="fas fa-unlock-alt" style="width: 20px; height: 20px"></i>
            </span>
          </div>
          <input 
            type="password"
            id="password"
            class="form-control" 
            placeholder="6～16位字母/数字" 
            name="password"
          >
        </div>
      </div>
      <!-- Confirm Password -->
      <div class='form-group'>
        <div class="input-group input-group-lg">
          <div class="input-group-prepend">
            <span class='input-group-text'>
              <i class="fas fa-unlock-alt" style="width: 20px; height: 20px"></i>
            </span>
          </div>
          <input 
            type="password" 
            id="confirmpassword"
            class="form-control" 
            placeholder="确认密码"
            name="confirmpassword"
          >
        </div>
      </div>
      <!-- Confirm Button -->
      <br />
      <button class='btn btn-success btn-lg btn-block' type="submit" style='text-align: center'>注册</button>
      <br/>
      <h5 style='text-align: center; color: white'>去下载APP <a href='http://feifan.game.withjoy.cn/download/?tmid=0' target="_blank" style='color: red'>请点这里</span></h5>
    </form>

    <script
      src="https://code.jquery.com/jquery-3.4.1.min.js"
      integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
      crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <script>

      function requestNewVerifyCode(cb) {
        $.ajax({
          type: "GET",
          url: './apis/request_new_code.php',
          dataType: 'json',
          success: function (obj, textstatus) {
            if(!!obj) {
                cb(obj);
            }
            else {
                console.log(obj.error);
            }
          }
        });
      }

      (function(){

        <?php 
          if($fromInvalidSubmitState) {
            echo 'alert("注册要求失败，请再尝试。")'."\n";
            echo 'history.pushState(null, "", location.href.split("?")[0]);';
          }
        ?>

        let confirmPasswordField = document.getElementById('confirmpassword');
        let passwordField = document.getElementById('password');
        let verifyField = document.getElementById('verify');
        let verifyTacField = document.getElementById('verifytac');
        let phoneField = document.getElementById('phonenumber');

        document.addEventListener("DOMContentLoaded", function(event) {
          requestNewVerifyCode(function(uri){
            $('#verifycode').find('img').attr('src', uri);
          });
        });

        $('#login_form').on('submit', function(e) {
          if (!phoneField.value) {
            alert("联络号码必填"); 
            phoneField.focus();
            return false;
          }

          if (!passwordField.value) {
            alert("密码必填"); 
            passwordField.focus();
            return false;
          }

          if (!verifyField.value) {
            alert("图形验证码必填"); 
            verifyField.focus();
            return false;
          }

          if (!verifyTacField.value) {
            alert("手机验证码必填"); 
            verifyTacField.focus();
            return false;
          }

          if (!/^[a-zA-Z0-9]{6,16}$/.test(passwordField.value)) {
            alert("请输入6～16位字母/数字"); 
            passwordField.focus();
            return false;
          }

          if (passwordField.value !== confirmPasswordField.value) {
            alert("请确认您的密码是否正确。");
            confirmPasswordField.focus();
            return false;
          }

          return true;
        })

        $('#verifycode').click(function(e) {
          // Prevent form submission
          e.preventDefault();
          requestNewVerifyCode(function(uri){
            $(this).find('img').attr('src', uri);
          }.bind(this));
        })

        $('#taccode').click((e) => {
          e.preventDefault();
          alert('手机验证码已发送。请输入‘123456’');
        })
      })()
    </script>

</body>

</html>