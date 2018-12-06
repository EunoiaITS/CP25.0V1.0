<?php if(isset($_SESSION['public_user_id']) && $_SESSION['public_user_id'] > 0){header("Location:".Request::$BASE_URL);} ?>
<?php include_once('TopNav.php'); ?>

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
			  <h1>Reset Password<small></small></h1>
			</div>
		</div>
	</div>

	<ol class="breadcrumb">
		<li><a href="<?php echo Request::$BASE_URL; ?>">Home</a></li>
		<li class="active">Login / Reset Password</li>
	</ol>

	

	<div class="row">
		<div class="col-md-6">
            <?php if (!empty($_SESSION['password_success_msg']) || !empty($_SESSION['password_mismatched_msg'])|| !empty($_SESSION['link_expired_msg'])|| !empty($_SESSION['invalid_user_msg'])) { ?>
                <h4>
                    <?php print_r($_SESSION['password_success_msg']); ?>
                    <?php print_r($_SESSION['password_mismatched_msg']); ?>
                    <?php print_r($_SESSION['link_expired_msg']); ?>
                    <?php print_r($_SESSION['invalid_user_msg']);
                    unset($_SESSION['password_success_msg']);
                    unset($_SESSION['password_mismatched_msg']);
                    unset($_SESSION['link_expired_msg']);
                    unset($_SESSION['invalid_user_msg']);

                    ?>

                </h4><br>
            <?php  }else{ ?>
                <h3>Enter New Password</h3><br>
            <?php } ?>

			<form action="<?php echo Request::$BASE_URL; ?>index.php/resetPassword" method="POST">
                <input type="password" class="form-control" placeholder="New Password" required name="password" id="password" /><br>
                <input type="password" class="form-control" placeholder="Re-Type Password" required name="passwordr" id="email" />
					<br />
				<input type="submit" name="submit" value="Login" class="btn btn-block btn-success" />
			</form>
			<br />
		</div>
		<!-- left side of search ends -->


	</div>
	<!-- main row ends -->
	

	
</div>
<!-- container ends -->

