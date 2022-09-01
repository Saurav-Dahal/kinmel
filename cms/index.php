<?php require $_SERVER['DOCUMENT_ROOT'].'config/init.php';
  $page_title= 'Login Page';
 ?>
  <?php if(isset($_SESSION['session_token'])){
   redirect('./dashboard');
  } ?>
<?php require 'inc/header.php'; ?>

    <div>
      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
           <?php flash(); ?>
            <form method="post" action="process/login">
              <h1>Login Form</h1>
              <div>
                <input type="text" name="username"  class="form-control" placeholder="Username" required="" />
              </div>
              <div>
                <input type="password"   name="password" class="form-control" placeholder="Password" required="" />
              </div>
              <div>
                <button class="btn btn-success submit">Log in</button>
                
              </div>

              <div class="clearfix"></div>

              
            </form>
          </section>
        </div>

      </div>
    </div>
  <?php require 'inc/footer.php '?>
