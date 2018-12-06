
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
                    <h1 class="page-header">Manage Keywords</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- Page Header -->

            <div class="row">
                <div class="col-md-12">
                    <a href="<?php echo Request::$BASE_URL; ?>index.php/adminReindex" class="btn btn-block btn-warning">Re-Index</a>
                </div>
            </div>
            <br>
            <div class="row">
                <form action="<?php echo Request::$BASE_URL; ?>index.php/addKeyword" method="POST">
                <div class="col-md-8">
                    <input type="text" class="form-control" name="keyword" placeholder="Add new keyword" />
                </div>
                <div class="col-md-4">
                    <input type="submit" class="btn btn-block btn-primary" value="Add keyword" />
                </div>
                </form>
            </div>


           <!--  <form action="<?php echo Request::$BASE_URL; ?>index.php/post" method="POST">
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
            </form> -->
            
            <br><br>
            <div class="row">
                <div class="col-md-12"><h3>Keywords List</h3></div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <form action="<?php echo Request::$BASE_URL; ?>index.php/post" method="POST">
                    <table class="table table-bordered table-striped ">
                        <tr>
                            <th>#</th>
                            <th>Keyword</th>
                            <th>Quran</th>
                            <th>Hadith</th>
                            <th>Manuscript</th>
                            <th>Scientific Articles</th>
                            <th></th>
                            <th></th>
                        </tr>
                       <?php if($keyword_index){ $x=1; foreach ($keyword_index as $q): ?>
                       <tr <?php if(!$q->is_approved){ ?>class="danger"<?php } ?> data-id="<?php echo $q->id; ?>">
                            <td><?php echo $x; $x++; ?></td>
                            <td class="keyword"><?php echo $q->keyword; ?></td>
                            <td class="quran"><?php echo $q->quran; ?></td>
                            <td class="hadith"><?php echo $q->hadith; ?></td>
                            <td class="manuscript"><?php echo $q->manuscript; ?></td>
                            <td class="scientific_article"><?php echo $q->scientific_article; ?></td>
                            <td class="edit_button"><a href="<?php echo Request::$BASE_URL; ?>index.php/adminEditKeywords/<?php echo $q->id; ?>" class="btn btn-success btn-block">Manage</a></td>
                            <form onSubmit="return confirm('Are you sure you want to delete?')" method="POST" action="<?php echo Request::$BASE_URL; ?>index.php/post">
                                <input type="hidden" name="table" value="keyword_index" />
                                <input type="hidden" name="id" value="<?php echo $q->id; ?>" />
                                <input type="hidden" name="is_active" value="0" />
                                <td>
                                    <input type="submit" value="DELETE" class="btn btn-block btn-danger" />
                                </td>
                            </form>
                            <?php if(!$q->is_approved && $_SESSION['user_permission']==1){ ?>
                            <form onSubmit="return confirm('Are you sure you want to approve this?')" method="POST" action="<?php echo Request::$BASE_URL; ?>index.php/post">
                                <input type="hidden" name="table" value="keyword_index" />
                                <input type="hidden" name="id" value="<?php echo $q->id; ?>" />
                                <input type="hidden" name="is_approved" value="1" />
                                <td>
                                    <input type="submit" value="APPROVE" class="btn btn-block btn-success" />
                                </td>
                            </form>
                            <?php } ?>
                            <!-- <td class="syn_button"><button type="button" onClick="return addSyn(this)" data-toggle="modal" data-target="#addSyn" class="btn btn-primary btn-block">Add Synonym</button></td> -->
                       </tr>    
                       <?php endforeach; } ?>
                    </table>
                    </form>
                </div>
            </div>
            <?php Pagination::pagesBlock("keyword_index",30,Request::$BASE_URL."index.php/adminKeywords"); ?>
        </div>
        <!-- /#page-wrapper -->

        <!-- Modal --
        <div class="modal fade" id="addSyn" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add Synonym</h4>
              </div>
              <form action="<?php echo Request::$BASE_URL ?>index.php/addSynonym" method="POST">
              <div class="modal-body">
                <input type="hidden" name="table" value="keyword_index" />
                <input type="hidden" name="linked_to" id="linked_to" value="" />
                <input type="text" name="keyword" class="form-control" placeholder="Synonym">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Add</button>
              </div>
              </form>
            </div>
          </div>
        </div>-->

    </div>
    <!-- /#wrapper -->