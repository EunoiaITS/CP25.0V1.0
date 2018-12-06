
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
                    <h1 class="page-header">Manage Manuscript</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- Page Header -->

            <form action="<?php echo Request::$BASE_URL; ?>index.php/post" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="table" value="manuscript">
            <div class="row">
                <div class="col-md-6">
                    <label> Original Text
                        <textarea class="form-control" name="trans_arabic" rows="5"></textarea>
                    </label>

                    <label> Manuscript (Malay)
                        <textarea class="form-control" name="trans_malay" rows="5"></textarea>
                    </label>

                    <label> Manuscript (English)
                        <textarea class="form-control" name="trans_english" rows="5"></textarea>
                    </label>
                    
                </div>

                <div class="col-md-6">
                    <label> Manuscript no #
                    <input type="text" required name="manuscript_no" class="form-control" placeholder="Manuscript No.">
                    </label>

                    <label> Bab
                    <input type="text" required name="bab" class="form-control" placeholder="Bab">
                    </label>

                    <label> Page
                    <input type="text" required name="page" class="form-control" placeholder="Page">
                    </label>

                    <label>
                        Image
                        <input type="file" name="path" />
                    </label>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <input type="submit" name="submit" class="btn btn-success btn-block" value="Add Manuscript">
                </div>
            </div>
            </form>
            
            <br><br>
            <div class="row">
                <div class="col-md-12"><h3>Manuscript List</h3></div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <form action="<?php echo Request::$BASE_URL; ?>index.php/post" enctype="multipart/form-data" method="POST">
                    <table class="table table-bordered table-striped ">
                        <tr>
                            <th>#</th>
                            <th>Manuscript No.</th>
                            <th>Bab</th>
                            <th>Page</th>
                            <th>Image</th>
                            <th>Original Text</th>
                            <th>Enlgish</th>
                            <th>Malay</th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                       <?php if(isset($manuscript)){ $x=1; foreach ($manuscript as $q): ?>
                       <tr <?php if(!$q->is_approved){ ?>class="danger"<?php } ?> data-id="<?php echo $q->id; ?>">
                            <td><?php echo $x; $x++; ?></td>
                            <td class="manuscript_no"><?php echo $q->manuscript_no; ?></td>
                            <td class="bab"><?php echo $q->bab; ?></td>
                            <td class="page"><?php echo $q->page; ?></td>
                            <td class="image">
                                <?php if($q->path){ ?>
                                <img src="<?php echo $q->path; ?>" width="100" />
                                <?php } ?>
                            </td>
                            <td class="trans_arabic"><?php echo $q->trans_arabic; ?></td>
                            <td class="trans_english"><?php echo $q->trans_english; ?></td>
                            <td class="trans_malay"><?php echo $q->trans_malay; ?></td>
                            <td class="edit_button"><button type="button" onClick="return editManuscript(this)" class="btn btn-success btn-block">Edit</button></td>
                    </form>
                            
                            <td><a href="<?php echo Request::$BASE_URL ?>index.php/adminEditManuscript/<?php echo $q->id; ?>" class="btn btn-block btn-primary">Additional<br/>Information</a></td>
                            <?php if(!$q->is_approved && $_SESSION['user_permission']==1){ ?>
                            <form onSubmit="return confirm('Are you sure you want to approve this?')" method="POST" action="<?php echo Request::$BASE_URL; ?>index.php/post">
                                <input type="hidden" name="table" value="manuscript" />
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
            <?php Pagination::pagesBlock("manuscript",30,Request::$BASE_URL."index.php/adminManuscript"); ?>
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->