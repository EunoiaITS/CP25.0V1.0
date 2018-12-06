
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
                    <h1 class="page-header">Add Event </h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- Page Header -->

            <form action="<?php echo Request::$BASE_URL; ?>index.php/post" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="table" value="events">
            <div class="row">
                <div class="col-md-6">
                    <label> Event Name / Title
                        <input type="text" required name="title" class="form-control" placeholder="Event Name / Title">
                    </label>

                    <label> Address
                        <input type="text" name="address" class="form-control" placeholder="Address ">
                    </label>
                    <label>Event Image
                        <input type="file" required name="path" class="form-control" >
                    </label>
                    <label>Event Description
                        <textarea id="description" class="form-control" name="description" rows="5"></textarea>
                    </label>


                </div><br>
                <div class='col-sm-6 col-md-5'>
                    <div class="col-sm-6 col-md-3"> Date From: </div>
                    <div class="form-group">
                        <div style="margin-left:22px; " class='input-group date' id='datetimepicker1'>
                            <input  type='date' class="datepicker form-control" name="date_from"  />
                            <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                        </div>
                    </div>
                </div><br><br><br>
                <div class='col-sm-6 col-md-5'>
                    <div class="col-sm-6 col-md-3"> Date Till: </div>
                    <div class="form-group">
                        <div style="margin-left:22px; " class='input-group date' id='datetimepicker1'>
                            <input  type='date' class="datepicker form-control" name="date_till"/>
                            <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row"><br>
                <div class="col-md-12">
                    <input type="submit" name="submit" class="btn btn-success btn-block" value="Add Event">
                </div>
            </div>
            </form>
            
            <br>
            <div class="row">
                <div class="col-md-12"><h3>All Events</h3></div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <form action="<?php echo Request::$BASE_URL; ?>index.php/post" method="POST">
                    <table class="table table-bordered table-striped ">
                        <tr>
                            <th>#</th>
                            <th>Event Title / Name</th>
<!--                            <th>Article Author / Publisher</th>-->
<!--                            <th>Article URL</th>-->
<!--                            <th>Disease 1</th>-->
<!--                            <th>Disease 2</th>-->
                            <th>Event Description</th>
                            <th>Event Address</th>
                            <th></th>
                            <th></th>

                        </tr>
                       <?php if(isset($event)){ $x=1; foreach ($event as $q): ?>
                       <tr <?php if(!$q->is_approved){ ?>class="danger"<?php } ?> data-id="<?php echo $q->id; ?>">
                            <td><?php echo $x; $x++; ?></td>
                            <td class="title"><?php echo $q->title; ?></td>
                           <td class="description"><?php echo $q->description; ?></td>
                           <td class="address"><?php echo $q->address; ?></td>
                           <td class="edit_button"><button type="button" onClick="return editEvent(this)" class="btn btn-success btn-block">Edit</button></td>
                           <td><a onClick="return confirm('Are you sure you want to delete this Topic? \n\nWARNING: This delete can not be recovered.')" href="<?php echo Request::$BASE_URL ?>index.php/adminDelete/events/<?php echo $q->id; ?>" class="btn btn-block btn-danger">Delete</a></td>

                    </form>

                       </tr>    
                       <?php endforeach; } ?>
                    </table>
                </div>
            </div>
            <?php Pagination::pagesBlock("events",10,Request::$BASE_URL."index.php/adminEvents"); ?>
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
<script type="text/javascript" src="<?php echo Request::$BASE_URL ?>ckeditor/ckeditor.js"></script>
<?php editor("inf"); ?>
<?php editor("description"); ?>
