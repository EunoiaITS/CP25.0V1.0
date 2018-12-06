
<body>
<style type="text/css">
    label{
        width:100%;
    }
</style>
    <div id="wrapper">

        <?php include_once("AdminNav.php"); ?>

        <div id="page-wrapper">
            <!-- Page Header -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Advertisement Manager </h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- Page Header -->

            <form action="<?php echo Request::$BASE_URL; ?>index.php/post" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="table" value="advertisement">
            <div class="row">
                <div class="col-md-6">

                    <label> Advertisement Image
                        <input type="file" required name="path" class="form-control" >
                    </label>

                    <label> Advertisement Position
                        <input type="number" required name="position" class="form-control" placeholder="Advertisement Position">
                    </label>

                </div><br>


            </div>

            <div class="row"><br>
                <div class="col-md-12">
                    <input type="submit" name="submit" class="btn btn-success btn-block" value="Add Advertisement">
                </div>
            </div>
            </form>
            
            <br>
            <div class="row">
                <div class="col-md-12"><h3>All Advertisements</h3></div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <form action="<?php echo Request::$BASE_URL; ?>index.php/post" method="POST">
                    <table class="table table-bordered table-striped ">
                        <tr>
                            <th>#</th>
                            <th>Advertisement Image</th>
                            <th></th>

                        </tr>
                       <?php if(isset($advertisement)){ $x=1; foreach ($advertisement as $q): ?>
                       <tr <?php if(!$q->is_approved){ ?>class="danger"<?php } ?> data-id="<?php echo $q->id; ?>">
                            <td><?php echo $x; $x++; ?></td>
                            <td class="title"><img  width="500" height="250" src="<?php echo Request::$BASE_URL.$q->short_path; ?>" alt="Los Angeles"></td>
                           <td><a onClick="return confirm('Are you sure you want to delete this Topic? \n\nWARNING: This delete can not be recovered.')" href="<?php echo Request::$BASE_URL ?>index.php/adminDelete/advertisement/<?php echo $q->id; ?>" class="btn btn-block btn-danger">Delete</a></td>

                    </form>

                       </tr>    
                       <?php endforeach; } ?>
                    </table>
                </div>
            </div>
            <?php Pagination::pagesBlock("advertisement",10,Request::$BASE_URL."index.php/adminAdvertisements"); ?>
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
<script type="text/javascript" src="<?php echo Request::$BASE_URL ?>ckeditor/ckeditor.js"></script>
<?php editor("inf"); ?>
<?php editor("description"); ?>
