<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title> Forgot Password </title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url('assets/theme/bower_components/bootstrap/dist/css/bootstrap.min.css'); ?>">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url('assets/theme/bower_components/font-awesome/css/font-awesome.min.css'); ?>">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url('assets/theme/bower_components/Ionicons/css/ionicons.min.css'); ?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url('assets/theme/dist/css/AdminLTE.min.css'); ?>">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo base_url('assets/theme/plugins/iCheck/square/blue.css'); ?>">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page overlay-wrapper">
<div class="login-box overlay-wrapper">
  <div class="login-logo">
    <a><b>ReGreen</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body ">
    <div class="main">
      <p class="login-box-msg">Forgot Password</p>
      <form method="post">
        <div class="form-group has-feedback">
          <input type="password" class="form-control" placeholder="Password" name="password">
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
          <input type="password" class="form-control" placeholder="Confirm Password" name="cpassword">
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row">
          <div class="col-xs-4">
          </div>
          <!-- /.col -->
          <div class="col-xs-4">
            <a class="btn btn-primary btn-block btn-flat submit">Submit</a>
          </div>
          <!-- /.col -->
        </div>
      </form>
    </div>
    <p class="login-box-msg expired">This link is used or expired. Request a new one.</p>
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="<?php echo base_url('assets/theme/bower_components/jquery/dist/jquery.min.js'); ?>"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url('assets/theme/bower_components/bootstrap/dist/js/bootstrap.min.js'); ?>"></script>
<!-- iCheck -->
<script src="<?php echo base_url('assets/theme/plugins/iCheck/icheck.min.js'); ?>"></script>
<script>
  var id = -1;
  function loadingStart() {
    $('.overlay').show();
  }

  function loadingStop() {
    $('.overlay').hide();
  }
  // loadingStop();
  $('.main').hide();
  $('.expired').hide();
  $('.login-box').hide();
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });

    $(".submit").click(function() {
      if($('[name="password"]').val() === ''){
        alert('Password must be same.');
      } else if($('[name="cpassword"]').val() != $('[name="password"]').val()){
        alert('Both password must be same.');
      } else {
        $.ajax({
          url: "<?php echo site_url('forgotPassword/resetPassword/'); ?>"+id,
          method: 'POST',
          data: {user_id: id, password: $('[name="cpassword"]').val()},
          dataType: "json",
          success: function(result) {
            if (result.success) {
              alert(result.msg);
              window.location.href = "http://www.regreen.co.in";
            } else {
              alert(result.msg);
            }
          }
        });
      }
    });
    $.ajax({
        url: "<?php echo site_url('forgotPassword/checkToken/'); echo $token; ?>",
        method: 'GET',
        dataType: "json",
        success: function(result) {
          $('.overlay').hide();
          if (result.success) {
              id = result.data.user_id;
              $('.main').show();
              $('.expired').hide();
              $('.login-box').show();
          } else {
              $('.main').hide();
              $('.expired').show();
              $('.login-box').show();
          }
        }
      });
    $('[name="password"]').keyup(function (event) {
        if (event.keyCode == 13) {
            $('.submit').click();
        }
    });
  });
</script>
<div class="overlay">
 <i class="fa fa-refresh fa-spin"></i>
</div>
</body>
</html>
