<?php
    session_start();
    if(isset($_SESSION['user']))
        header('location: dashboard.php');
?>
<link rel="stylesheet" href="./styles/main.css">
<?php require_once "../Userspace/includes/header.php" ?>
    <section class="login ">
            <div class="container py-5">
                <div id="logincontainer" class="row g-0 shadow overflow-hidden ">
                    <div class="col-lg-5 shadow-sm d-none d-lg-flex justify-content-center overflow-hidden"  style="height: 600px;">
                        <img src="assets/Mobile-login-Cristina.jpg" class="" alt="" style="height: 100%;">
                    </div>
                    <div class="col-lg-7 py-4 px-5 ">
                        <div class="col text-end pb-3">
                            <p class="d-inline text-muted">Don't have an account?</p>
                            <a class="d-inline btn btn-outline-secondary  rounded-pill px-4 fw-bold"  href="signup.php">Sign Up</a>
                        </div>
                        <div>
                            <form class="row justify-content-center mt-5" action="action.php" autocomplete="off" method="post">  
                                <h1 class="row col-sm-9 col-12 fw-bolder text-nowrap mb-0 primary-900">Welcome to Userspace!</h1>
                                <h5 class="row col-sm-9 col-12 fw-bold text-muted">Get into your account</h5>
                                <div class="row col-sm-9 col-12">   
                                    <label class="fw-bold px-0 py-1 primary-900">Username</label>   
                                    <input id="username" class="form-control fs-6 py-2 mb-2" type="text" placeholder="Enter Username" name="username" required>
                                    <label class="fw-bold px-0 py-1 mt-1 primary-900">Password</label>
                                    <input id="password" class="form-control fs- py-2 mb-2" type="password" placeholder="Enter Password" name="password" required>
                                    <a class="mb-3 link-primary my-1 px-0" href="#"> Forgot your password?</a>
                                    <button class="btn-lg btn-primary" id="loginbutton" type="submit" name="login">Log In</button>
                                    <?php
                                        if(isset($_GET['err']))  
                                            echo '<label class="text-danger" style="width:100%;text-align:center;color:#DE6666;font-size:18px;margin-top:25px;">'.$_GET["err"] .'</label>';
                                    ?>  
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <?php require_once "../Userspace/includes/footer.php" ?>
    </body> 
</html> 
