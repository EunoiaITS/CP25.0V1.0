<?php if(isset($_SESSION['public_user_id']) && $_SESSION['public_user_id'] > 0){header("Location:".Request::$BASE_URL);} ?>
<?php include_once('TopNav.php'); ?>

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
			  <h1>Forgot Password<small></small></h1>
			</div>
		</div>
	</div>

	<ol class="breadcrumb">
		<li><a href="<?php echo Request::$BASE_URL; ?>">Home</a></li>
		<li class="active">Login / Forgot Password</li>
	</ol>

	

	<div class="row">
		<div class="col-md-6">
            <?php if (!empty($_SESSION['email_success']) || !empty($_SESSION['email_error'])) { ?>
                <h4>
                    <?php print_r($_SESSION['email_success']); ?>
                    <?php print_r($_SESSION['email_error']);
                    unset($_SESSION['email_success']);
                    unset($_SESSION['email_error']);

                    ?>

                </h4><br>
          <?php  }else{ ?>
			<h4>Please enter your email address to get back your account
            </h4><br>
              <?php } ?>
			<form action="<?php echo Request::$BASE_URL; ?>index.php/forgotPassword" method="POST">
				<input type="email" class="form-control" placeholder="Email" required name="email" id="email" />
					<br />
				<input type="submit" name="submit" value="Submit" class="btn btn-block btn-success" />
			</form>
			<br />
		</div>
		<!-- left side of search ends -->


	</div>
	<!-- main row ends -->
	

	
</div>
<!-- container ends -->

