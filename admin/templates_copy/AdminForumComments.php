
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
                    <h1 class="page-header">All Comments</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- Page Header -->

            <div class="row">
                <div class="col-md-12">
                    <form action="<?php echo Request::$BASE_URL; ?>index.php/post" method="POST">
                    <table class="table table-bordered table-striped ">
                        <tr>
                            <th>#</th>
                            <th>User Name</th>
                            <th>Comments</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                       <?php if($comments){ $x=1; foreach ($comments as $q): ?>
                       <tr data-id="<?php echo $q->comment_id;?>" <?php if(!$q->is_approved){ ?>class="danger"<?php } ?>">
                            <td><?php echo $x; $x++; ?></td>
                            <td class="type_title"><?php echo $q->name; ?></td>
                            <td class="information"><?php echo $q->message; ?></td>
                           <td class="reply"></td>
                        <input type="hidden" name="table" value="comments_reply" />
<!--                        <input type="hidden" name="comment_id" value="--><?php //echo $q->comment_id; ?><!--" />-->
                        <input type="hidden" name="topic_id" value="<?php echo $q->topic_id; ?>" />
                        <input type="hidden" name="user_public_id" value="<?php echo $q->user_public_id; ?>" />
                           <td class="edit_button"><button type="button" onClick="return replyComment(this)" class="btn btn-success btn-block">Reply</button></td>

                    </form>
                            
                            <td><a onClick="return confirm('Are you sure you want to delete this comment? \n\nWARNING: This delete can not be recovered.')" href="<?php echo Request::$BASE_URL ?>index.php/adminDelete/comments/<?php echo $q->comment_id; ?>" class="btn btn-block btn-danger">Delete</a></td>
                            
                            <?php if(!$q->is_approved && $_SESSION['user_permission']==1){ ?>
                            <form onSubmit="return confirm('Are you sure you want to approve this?')" method="POST" action="<?php echo Request::$BASE_URL; ?>index.php/post">
                                <input type="hidden" name="table" value="comments" />
                                <input type="hidden" name="id" value="<?php echo $q->comment_id; ?>" />
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
            
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
    <script type="text/javascript" src="<?php echo Request::$BASE_URL ?>ckeditor/ckeditor.js"></script>
<?php editor("info"); ?>