<nav class="navbar navbar-default">
  <div class="container-fluid">
	<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		<form action="<?php echo Request::$BASE_URL ?>index.php/results" method="GET">
			<ul class="nav navbar-nav navbar-left">
				<li>
					<img src="<?php echo Request::$BASE_URL; ?>images/logo.png" height="50px" />
				</li>
				<li class="nav-search">
					<input type="text" class="form-control" placeholder="Search"  value="<?php echo $search ?>" name="search" />
				</li>
				<li class="nav-search">
					<input type="submit" value="Search" class="btn btn-block btn-danger" />

				</li>
			</ul>
		</form>
		<ul class="nav navbar-nav navbar-right">
	        <li><a href="#">About Us</a></li>
	        <li><a href="#">Permission</a></li>
	        <li><a href="#">Guide</a></li>
	        <li><a href="#">Register/Sign In</a></li>
      	</ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>


<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
			  <h1><?php echo strtoupper($_GET['type']) ?><small> details</small></h1>
			</div>
		</div>
	</div>

	<!-- <ol class="breadcrumb">
		<li class="active">Top Quran Results</li>
		<li><a href="#">View All</a></li>
	</ol> -->

	

	<div class="row">
		<div class="col-md-9">
			

		</div>
		<!-- left side of search ends -->

		<div class="col-md-3">
			
		</div>
		<!-- right side of search ends -->
	</div>
	<!-- main row ends -->
	

	
</div>
<!-- container ends -->


