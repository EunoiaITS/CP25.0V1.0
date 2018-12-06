
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
                    <h1 class="page-header">Add Topic </h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- Page Header -->

            <form action="<?php echo Request::$BASE_URL; ?>index.php/post" method="POST">
                <input type="hidden" name="table" value="forum_topic">
            <div class="row">
                <div class="col-md-6">
                    <label> Topic Name / Title
                        <input type="text" required name="title" class="form-control" placeholder="Topic Name / Title">
                    </label>

<!--                    <label> Article Author / Publisher-->
<!--                        <input type="text" name="author" class="form-control" placeholder="Article Author / Publisher">-->
<!--                    </label>-->

                    <label> Description
                        <textarea class="form-control" name="description" rows="5"></textarea>
                    </label>
                    
                </div>

            </div>

            <div class="row"><br>
                <div class="col-md-12">
                    <input type="submit" name="submit" class="btn btn-success btn-block" value="Add Topic">
                </div>
            </div>
            </form>
            
            <br>
            <div class="row">
                <div class="col-md-12"><h3>All Topics</h3></div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <form action="<?php echo Request::$BASE_URL; ?>index.php/post" method="POST">
                    <table class="table table-bordered table-striped ">
                        <tr>
                            <th>#</th>
                            <th>Topic Title / Name</th>
<!--                            <th>Article Author / Publisher</th>-->
<!--                            <th>Article URL</th>-->
<!--                            <th>Disease 1</th>-->
<!--                            <th>Disease 2</th>-->
                            <th>Description</th>
                            <th></th>
                            <th></th>
                            <th></th>

                        </tr>
                       <?php if(isset($topic)){ $x=1; foreach ($topic as $q): ?>
                       <tr <?php if(!$q->is_approved){ ?>class="danger"<?php } ?> data-id="<?php echo $q->id; ?>">
                            <td><?php echo $x; $x++; ?></td>
                            <td class="title"><?php echo $q->title; ?></td>
                            <td class="description"><?php echo $q->description; ?></td>
                           <td class="edit_button"><button type="button" onClick="return editTopic(this)" class="btn btn-success btn-block">Edit</button></td>
                           <td><a onClick="return confirm('Are you sure you want to delete this Topic? \n\nWARNING: This delete can not be recovered.')" href="<?php echo Request::$BASE_URL ?>index.php/adminDelete/forum_topic/<?php echo $q->id; ?>" class="btn btn-block btn-danger">Delete</a></td>

                    </form>
                            
                            <td><a href="<?php echo Request::$BASE_URL ?>index.php/adminForumComments/<?php echo $q->id; ?>" class="btn btn-block btn-primary">Comments</a></td>
                            <?php if(!$q->is_approved && $_SESSION['user_permission']==1){ ?>
                            <form onSubmit="return confirm('Are you sure you want to approve this?')" method="POST" action="<?php echo Request::$BASE_URL; ?>index.php/post">
                                <input type="hidden" name="table" value="forum_topic" />
                                <input type="hidden" name="id" value="<?php echo $q->id; ?>" />
                                <input type="hidden" name="is_approved" value="1" />
                                <td>
                                    <input type="submit" value="APPROVE" class="btn btn-block btn-success" />
                                </td>
                            </form>
                            <?php } ?>
                       </tr>    
                       <?php endforeach; } ?>
                    </table>
                </div>
            </div>
            <?php Pagination::pagesBlock("forum_topic",10,Request::$BASE_URL."index.php/adminForum"); ?>
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
<script type="text/javascript" src="<?php echo Request::$BASE_URL ?>ckeditor/ckeditor.js"></script>
<?php editor("info"); ?>