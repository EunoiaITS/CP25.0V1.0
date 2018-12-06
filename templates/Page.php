<?php include_once('TopNav.php'); ?>


<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<?php if(isset($data) && count($data)>0){ ?>
			  		<h1><?php echo strtoupper($_GET['type']) ?><small> details</small></h1>
			  	<?php } ?>

			  	<?php if(isset($pf->id) ){ ?>
			  		<h1><?php echo $pf->type_title; ?></h1>
			  	<?php } ?>
			</div>
		</div>
	</div>

	<!-- <ol class="breadcrumb">
		<li class="active">Top Quran Results</li>
		<li><a href="#">View All</a></li>
	</ol> -->

	

	<?php if(isset($data) && count($data)>0){ ?>
	<div class="row">
		<div class="col-md-9">
			<table class="table table-bordered table-responsive table-striped table-hover">
				<tr>
					<th>Title</th>
					<th>Information</th>
				</tr>

				<?php if(isset($data)){foreach($data as $title=>$info){ ?>
				<tr>
					<td><?php echo $title; ?></td>
					<td><?php echo $info; ?></td>
				</tr>
				<?php }} ?>
			</table>

		</div>
		<!-- left side of search ends -->

		<div class="col-md-3">
			
		</div>
		<!-- right side of search ends -->
	</div>
	<!-- main row ends -->
	<?php } ?>

	<?php if(isset($pf->id) ){ ?>
		<div class="row">
			<div class="col-md-12">
				<?php echo $pf->information; ?>
			</div>
		</div>
	<?php } ?>
	
</div>
<!-- container ends -->


