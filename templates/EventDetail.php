<?php include_once('TopNav.php'); ?>


<div class="container">
	<div class="row">

        <div class="col-md-12">
            <div class="panel panel-default">
                <?php if(isset($data) && count($data)>0){ ?>
                <div class="panel-heading text-info ">
                    <div class="row">
                    <div class="col-md-8">
                    <h3 class="panel-title"><?php echo $data->title; ?>	</h3></div>
                        <div class="panel-title col-md-2"><h5><b>Date From: <?php echo $data->date_from; ?></b></h5></div>
                        <div class="col-md-2 panel-title"><h5><b>Date Till: <?php echo $data->date_till; ?></b></h5></div>

                </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div style="margin:2% 0% 3% 13%;">
                            <img  width="800" height="300" src="<?php echo Request::$BASE_URL;?>admin/<?php echo $data->short_path; ?>" alt="<?php echo $data->title?>">
                            </div>
                            <td><?php echo $data->description; ?></td>
                    </div>


                </div>
            </div>
        </div>



	</div>
	<?php }?>












</div>

<!-- container ends -->


