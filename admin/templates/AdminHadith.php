
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
                    <h1 class="page-header">Manage Hadith</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- Page Header -->

            <form action="<?php echo Request::$BASE_URL; ?>index.php/post" method="POST">
                <input type="hidden" name="table" value="hadith">
            <div class="row">
                <div class="col-md-6">
                    <label> Hadith (Arabic)
                        <textarea class="form-control" name="trans_arabic" rows="5"></textarea>
                    </label>

                    <label> Hadith (Malay)
                        <textarea class="form-control" name="trans_malay" rows="5"></textarea>
                    </label>

                    <label> Hadith (English)
                        <textarea class="form-control" name="trans_english" rows="5"></textarea>
                    </label>
                    
                </div>

                <div class="col-md-6">
                    <label> Kitab
                    <input type="text" required name="kitab" class="form-control" placeholder="Kitab">
                    </label>

                    <label> Bab
                    <input type="text" required name="bab" class="form-control" placeholder="bab">
                    </label>

                    <label> Vol
                    <input type="text" required name="vol" class="form-control" placeholder="Vol">
                    </label>

                    <label> Page
                    <input type="text" required name="page" class="form-control" placeholder="Page">
                    </label>

                    <label> Hadith No.
                    <input type="text" required name="hadith_no" class="form-control" placeholder="Hadith No.">
                    </label>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <input type="submit" name="submit" class="btn btn-success btn-block" value="Add Hadith">
                </div>
            </div>
            </form>
            
            <br><br>
            <div class="row">
                <div class="col-md-12"><h3>Hadith List</h3></div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <form action="<?php echo Request::$BASE_URL; ?>index.php/post" method="POST">
                    <table class="table table-bordered table-striped ">
                        <tr>
                            <th>#</th>
                            <th>Kitab</th>
                            <th>Bab</th>
                            <th>Vol</th>
                            <th>Page</th>
                            <th>Hadith No.</th>
                            <th>Hadith (Arabic)</th>
                            <th>Hadith (Enlgish)</th>
                            <th>Hadith (Malay)</th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                       <?php if(isset($hadith)){ $x=1; foreach ($hadith as $q): ?>
                       <tr <?php if(!$q->is_approved){ ?>class="danger"<?php } ?> data-id="<?php echo $q->id; ?>">
                            <td><?php echo $x; $x++; ?></td>
                            <td class="kitab"><?php echo $q->kitab; ?></td>
                            <td class="bab"><?php echo $q->bab; ?></td>
                            <td class="vol"><?php echo $q->vol; ?></td>
                            <td class="page"><?php echo $q->page; ?></td>
                            <td class="hadith_no"><?php echo $q->hadith_no; ?></td>
                            <td class="trans_arabic"><?php echo $q->trans_arabic; ?></td>
                            <td class="trans_english"><?php echo $q->trans_english; ?></td>
                            <td class="trans_malay"><?php echo $q->trans_malay; ?></td>
                            <td class="edit_button"><button type="button" onClick="return editHadith(this)" class="btn btn-success btn-block">Edit</button></td>
                    </form>
                            
                            <td><a href="<?php echo Request::$BASE_URL ?>index.php/adminEditHadith/<?php echo $q->id; ?>" class="btn btn-block btn-primary">Additional<br/>Information</a></td>
                            <?php if(!$q->is_approved && $_SESSION['user_permission']==1){ ?>
                            <form onSubmit="return confirm('Are you sure you want to approve this?')" method="POST" action="<?php echo Request::$BASE_URL; ?>index.php/post">
                                <input type="hidden" name="table" value="hadith" />
                                <input type="hidden" name="id" value="<?php echo $q->id; ?>" />
                                <input type="hidden" name="is_approved" value="1" />
                                <td>
                                    <input type="submit" value="APPROVE" class="btn btn-block btn-success" />
                                </td>
                            </form>
                            <?php } ?>
                    <form onSubmit="return confirm('Are you sure you want to make this hadith of the day?')" method="POST" action="<?php echo Request::$BASE_URL; ?>index.php/hadith_of_the_day">
                        <input type="hidden" name="table" value="hadith" />
                        <input type="hidden" name="id" value="<?php echo $q->id; ?>" />
                        <input type="hidden" name="hadith_of_the_day" value="1" />
                        <td>
                            <input type="submit" value="Make Hadith of the day" class="btn btn-block btn-success" />
                        </td>
                    </form>

                       </tr>    
                       <?php endforeach; } ?>
                    </table>
                </div>
            </div>
            <?php Pagination::pagesBlock("hadith",30,Request::$BASE_URL."index.php/adminHadith"); ?>
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->