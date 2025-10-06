<html>
    <head>
        <meta charset="utf-8">
        <title>Forget Password</title>
        <link rel="stylesheet" href="style.css">
        <!--icon social-->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <body>
        
        <div class="login-w">
            <div class="center" style="height: 550px;">
            <form method="post" action="php/resetPassword.php">
            <h1>Forget Password</h1>
            
                    <?php if (isset($_GET['error'])) { ?>
                        <div class="alert alert-danger text-center" role="alert"
                            style="position: absolute; top: -10%; left: 50%; transform: translate(-50%, -50%); color: black; background-color: rgba(255, 0, 0, 0.5);">
                            <?= $_GET['error'] ?>
                        </div>
                    <?php } ?>
       
                    <div class="txt_field">
                        <input id="email" name="username" type="text" placeholder="Enter your username">
                    </div>
                    <div class="txt_field">
                        <input id="pass" name="password" type="password" placeholder="Enter your password " />
                    </div>
                    <input id="submt-login" type="submit" value="Update Password" >
                    <br>
                    <br>
                    <br>
                    <a href="index.php">Back to Login</a>
                    </form>

                    
</body>
</html>

