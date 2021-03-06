
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
                    <h1 class="page-header">Edit Hadith</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- Page Header -->

             <div class="row">
                <div class="col-md-12">
                    <form action="<?php echo Request::$BASE_URL; ?>index.php/post" method="POST">
                    <table class="table table-bordered table-striped ">
                        <tr>
                            <th>Kitab</th>
                            <th>Bab</th>
                            <th>Page</th>
                            <th>Vol</th>
                            <th>Hadith No.</th>
                            <th>Hadith (Arabic)</th>
                            <th>Hadith (Enlgish)</th>
                            <th>Hadith (Malay)</th>
                        </tr>
                       <?php if(isset($hadith->id)){  ?>
                       <tr data-id="<?php echo $hadith->id; ?>">
                            <td class="kitab"><?php echo $hadith->kitab; ?></td>
                            <td class="bab"><?php echo $hadith->bab; ?></td>
                            <td class="vol"><?php echo $hadith->vol; ?></td>
                            <td class="page"><?php echo $hadith->page; ?></td>
                            <td class="hadith_no"><?php echo $hadith->hadith_no; ?></td>
                            <td class="trans_arabic"><?php echo $hadith->trans_arabic; ?></td>
                            <td class="trans_english"><?php echo $hadith->trans_english; ?></td>
                            <td class="trans_malay"><?php echo $hadith->trans_malay; ?></td>
                      </tr>    
                       <?php } ?>
                    </table>
                    </form>
                </div>
            </div>

            <form action="<?php echo Request::$BASE_URL; ?>index.php/post" method="POST">
                <input type="hidden" name="table" value="additional_information">
                <input type="hidden" name="type" value="hadith" />
                <input type="hidden" name="type_id" value="<?php if(isset($parameters[1])){echo $parameters[1];} ?>" />
            <div class="row">
                <div class="col-md-6">

                    <label> Information Title
                    <input type="text" required name="type_title" class="form-control" placeholder="Information Title">
                    </label>

                </div>

                <div class="col-md-6">

                    <label> Information
                        <textarea id="info" class="form-control" name="information" rows="5"></textarea>
                    </label>
                    
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <input type="submit" name="submit" class="btn btn-success btn-block" value="Add Additional Information">
                </div>
            </div>
            </form>
            
            <br><br>
            <div class="row">
                <div class="col-md-12"><h3>Additional Information List</h3></div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <form action="<?php echo Request::$BASE_URL; ?>index.php/post" method="POST">
                    <table class="table table-bordered table-striped ">
                        <tr>
                            <th>#</th>
                            <th>Information Title</th>
                            <th>Information</th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                       <?php if($additional_information){ $x=1; foreach ($additional_information as $q): ?>
                       <tr <?php if(!$q->is_approved){ ?>class="danger"<?php } ?> data-id="<?php echo $q->id; ?>">
                            <td><?php echo $x; $x++; ?></td>
                            <td class="type_title"><?php echo $q->type_title; ?></td>
                            <td class="information"><?php echo $q->information; ?></td>
                            <td class="edit_button"><button type="button" onClick="return editInfo(this)" class="btn btn-success btn-block">Edit</button></td>
                            <td><a onClick="return confirm('Are you sure you want to delete this additional information? \n\nWARNING: This delete can not be recovered.')" href="<?php echo Request::$BASE_URL ?>index.php/adminDelete/additional_information/<?php echo $q->id; ?>" class="btn btn-block btn-danger">Delete</a></td>
                             <?php if(!$q->is_approved && $_SESSION['user_permission']==1){ ?>
                            <form onSubmit="return confirm('Are you sure you want to approve this?')" method="POST" action="<?php echo Request::$BASE_URL; ?>index.php/post">
                                <input type="hidden" name="table" value="additional_information" />
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
                    </form>
                </div>
            </div>
            
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
    <script type="text/javascript" src="<?php echo Request::$BASE_URL ?>ckeditor/ckeditor.js"></script>
    <?php editor("info"); ?>