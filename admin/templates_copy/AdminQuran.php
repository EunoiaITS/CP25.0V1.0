
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
                    <h1 class="page-header">Manage Quran</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- Page Header -->

            <form action="<?php echo Request::$BASE_URL; ?>index.php/post" method="POST">
                <input type="hidden" name="table" value="quran">
            <div class="row">
                <div class="col-md-6">
                    <label> Ayat (Arabic)
                        <textarea class="form-control" name="ayat" rows="5"></textarea>
                    </label>

                    <label> Verse No.
                    <input type="number" required name="verse" class="form-control" placeholder="Verse #">
                    </label>

                    <label> Surah
                        <select name="surah" class="form-control" required>
                            <option value="">--</option>
                            <?php foreach($surah_index as $index){ ?>
                                <option value="<?php echo $index->id; ?>"><?php echo $index->id.": ".$index->surah." - ".$index->trans_english ?></option>
                            <?php } ?>
                        </select>
                    </label>

                </div>

                <div class="col-md-6">

                    <label> Ayat (Malay)
                        <textarea class="form-control" name="trans_malay" rows="5"></textarea>
                    </label>

                    <label> Ayat (English)
                        <textarea class="form-control" name="trans_english" rows="5"></textarea>
                    </label>
                    
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <input type="submit" name="submit" class="btn btn-success btn-block" value="Add Quran Ayat">
                </div>
            </div>
            </form>
            
            <br><br>
            <div class="row">
                <div class="col-md-12"><h3>Quran Ayat List</h3></div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <form action="<?php echo Request::$BASE_URL; ?>index.php/post" method="POST">
                    <table class="table table-bordered table-striped ">
                        <tr>
                            <th>#</th>
                            <th>Surah</th>
                            <th>Verse</th>
                            <th>Ayat (Arabic)</th>
                            <th>Ayat (Enlgish)</th>
                            <th>Ayat (Malay)</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                       <?php if(isset($quran)){ $x=1; foreach ($quran as $q): ?>
                       <tr <?php if(!$q->is_approved){ ?>class="danger"<?php } ?> data-id="<?php echo $q->id; ?>">
                            <td><?php echo $x; $x++; ?></td>
                            <td class="surah"><?php echo $q->surah; ?></td>
                            <td class="verse"><?php echo $q->verse; ?></td>
                            <td class="ayat"><?php echo $q->ayat; ?></td>
                            <td class="trans_english"><?php echo $q->trans_english; ?></td>
                            <td class="trans_malay"><?php echo $q->trans_malay; ?></td>
                           <td class="edit_button"><button type="button" onClick="return editQuran(this)" class="btn btn-success btn-block">Edit</button></td>
                    </form>
                            
                            <td><a href="<?php echo Request::$BASE_URL ?>index.php/adminEditQuran/<?php echo $q->id; ?>" class="btn btn-block btn-primary">Additional<br/>Information</a></td>
                            <?php if(!$q->is_approved && $_SESSION['user_permission']==1){ ?>
                            <form onSubmit="return confirm('Are you sure you want to approve this?')" method="POST" action="<?php echo Request::$BASE_URL; ?>index.php/post">
                                <input type="hidden" name="table" value="quran" />
                                <input type="hidden" name="id" value="<?php echo $q->id; ?>" />
                                <input type="hidden" name="ayat_of_the_day" value="1" />
                                <td>
                                    <input type="submit" value="APPROVE" class="btn btn-block btn-success" />
                                </td>
                            </form>
                            <?php } ?>
                    <form onSubmit="return confirm('Are you sure you want to make this Ayat of the day?')" method="POST" action="<?php echo Request::$BASE_URL; ?>index.php/ayat_of_the_day">
                        <input type="hidden" name="table" value="quran" />
                        <input type="hidden" name="id" value="<?php echo $q->id; ?>" />
                        <input type="hidden" name="is_approved" value="1" />
                        <td>
                            <input type="submit" value="Aya" class="btn btn-block btn-success" />
                        </td>
                    </form>
                       </tr>    
                       <?php endforeach; } ?>
                    </table>
                </div>
            </div>
            <?php Pagination::pagesBlock("quran",30,Request::$BASE_URL."index.php/adminQuran"); ?>
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->