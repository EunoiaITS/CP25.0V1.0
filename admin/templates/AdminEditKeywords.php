
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
                    <h1 class="page-header">Keyword: <i><?php echo $keyword->keyword; ?></i></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- Page Header -->

            <!-- <form action="<?php echo Request::$BASE_URL; ?>index.php/post" method="POST">
                <input type="hidden" name="table" value="user">
            <div class="row">
                <div class="col-md-6">
                    <label> Name
                    <input type="text" required name="name" class="form-control" placeholder="Name">
                    </label>

                    <label> Email
                    <input type="email" required name="email" class="form-control" placeholder="Email">
                    </label>

                    <label> Username
                    <input type="text" required name="username" class="form-control" placeholder="Username">
                    </label>

                </div>

                <div class="col-md-6">

                    <label> Permission
                    <select required name="type" class="form-control">
                        <option value="">--</option>
                        <option value="1">Web - Super Admin</option>
                        <option value="2">Web - Admin</option>
                        <option value="3">Surveyor</option>
                    </select>
                    </label>

                    <label> Password
                    <input type="password" required name="password" class="form-control" placeholder="Password">
                    </label>

                    <label> Repeat Password
                    <input type="password" required name="password2" class="form-control" placeholder="Repeat Password">
                    </label>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <input type="submit" name="submit" class="btn btn-success btn-block" value="Create User">
                </div>
            </div>
            </form> -->
        
            <div class="row">
                <div class="col-md-4"><h3>Quran List</h3></div>
                <form action="<?php echo Request::$BASE_URL; ?>index.php/linkQuran" method="POST">
                <div class="col-md-4">
                        <input type="hidden" name="keyword_id" value="<?php echo $parameters[1]; ?>" />
                        <select required name="quran_id" class="select3 form-control">
                            <option value="">Link Ayat</option>
                            <?php if(isset($ayats)){ foreach($ayats as $ayat){ ?>
                                <option value="<?php echo $ayat->id ?>"><?php echo $ayat->surah.":".$ayat->verse; ?></option>
                            <?php }} ?>
                        </select>
                </div>
                <div class="col-md-2">
                        <input type="submit" class="btn btn-block btn-success" value="Link Ayat" />
                </div>
                </form>
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
                        </tr>
                       <?php if(isset($quran[0]->id)){ $x=1; foreach ($quran as $q): ?>
                       <tr data-id="<?php echo $q->id; ?>">
                            <td><?php echo $x; $x++; ?></td>
                            <td class="surah"><?php echo $q->surah; ?></td>
                            <td class="verse"><?php echo $q->verse; ?></td>
                            <td class="ayat"><?php echo $q->ayat; ?></td>
                            <td class="trans_english"><?php echo $q->trans_english; ?></td>
                            <td class="trans_malay"><?php echo $q->trans_malay; ?></td>
                            <td class="delete_button"><a href="<?php echo Request::$BASE_URL; ?>index.php/adminUnlinkQuran/<?php echo $parameters[1]; ?>/<?php echo $q->id; ?>" class="btn btn-danger btn-block">Unlink</a></td>
                       </tr>    
                       <?php endforeach; } ?>
                    </table>
                    </form>
                </div>
            </div>
            <!-- Quran List Ends -->
            <hr>
            <div class="row">
                <div class="col-md-4"><h3>Hadith List</h3></div>
                <form action="<?php echo Request::$BASE_URL; ?>index.php/linkHadith" method="POST">
                <div class="col-md-4">
                        <input type="hidden" name="keyword_id" value="<?php echo $parameters[1]; ?>" />
                        <select required name="hadith_id" class="select4 form-control">
                            <option value="">Link Hadith</option>

                            <?php if(isset($hadiths)){ foreach($hadiths as $h){ ?>
                                <option value="<?php echo $h->id ?>"><?php echo $h->kitab.">".$h->bab.">".$h->vol.">".$h->hadith_no; ?></option>
                            <?php }} ?>
                        </select>
                </div>
                <div class="col-md-2">
                        <input type="submit" class="btn btn-block btn-success" value="Link Hadith" />
                </div>
                </form>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <form action="<?php echo Request::$BASE_URL; ?>index.php/post" method="POST">
                    <table class="table table-bordered table-striped ">
                        <tr>
                            <th>#</th>
                            <th>Kitab</th>
                            <th>Bab</th>
                            <th>Page</th>
                            <th>Vol</th>
                            <th>Hadith No.</th>
                            <th>Hadith (Arabic)</th>
                            <th>Hadith (Enlgish)</th>
                            <th>Hadith (Malay)</th>
                            <th></th>
                        </tr>
                       <?php if(isset($hadith[0]->id)){ $x=1; foreach ($hadith as $q): ?>
                       <tr data-id="<?php echo $q->id; ?>">
                            <td><?php echo $x; $x++; ?></td>
                             <td class="kitab"><?php echo $q->kitab; ?></td>
                            <td class="bab"><?php echo $q->bab; ?></td>
                            <td class="vol"><?php echo $q->vol; ?></td>
                            <td class="page"><?php echo $q->page; ?></td>
                            <td class="hadith_no"><?php echo $q->hadith_no; ?></td>
                            <td class="trans_arabic"><?php echo $q->trans_arabic; ?></td>
                            <td class="trans_english"><?php echo $q->trans_english; ?></td>
                            <td class="trans_malay"><?php echo $q->trans_malay; ?></td>
                            <td class="delete_button"><a href="<?php echo Request::$BASE_URL; ?>index.php/adminUnlinkHadith/<?php echo $parameters[1]; ?>/<?php echo $q->id; ?>" class="btn btn-danger btn-block">Unlink</a></td>
                       </tr>    
                       <?php endforeach; } ?>
                    </table>
                    </form>
                </div>
            </div>
            <!-- Hadith List Ends -->

            <hr>

            <div class="row">
                <div class="col-md-4"><h3>Manuscript List</h3></div>
                <form action="<?php echo Request::$BASE_URL; ?>index.php/linkManuscript" method="POST">
                <div class="col-md-4">
                        <input type="hidden" name="keyword_id" value="<?php echo $parameters[1]; ?>" />
                        <select required name="manuscript_id" class="select5 form-control">
                            <option value="">Link Manuscript</option>

                            <?php if(isset($manuscripts)){ foreach($manuscripts as $h){ ?>
                                <option value="<?php echo $h->id ?>"><?php echo $h->manuscript_no.">".$h->bab.">".$h->page; ?></option>
                            <?php }} ?>
                        </select>
                </div>
                <div class="col-md-2">
                        <input type="submit" class="btn btn-block btn-success" value="Link Manuscript" />
                </div>
                </form>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <form action="<?php echo Request::$BASE_URL; ?>index.php/post" method="POST">
                    <table class="table table-bordered table-striped ">
                        <tr>
                            <th>#</th>
                            <th>Manuscript No</th>
                            <th>Bab</th>
                            <th>Page</th>
                            <th>Hadith (Arabic)</th>
                            <th>Hadith (Enlgish)</th>
                            <th>Hadith (Malay)</th>
                            <th></th>
                        </tr>
                       <?php if(isset($manuscript[0]->id)){ $x=1; foreach ($manuscript as $q): ?>
                       <tr data-id="<?php echo $q->id; ?>">
                            <td><?php echo $x; $x++; ?></td>
                             <td class="manuscript_no"><?php echo $q->manuscript_no; ?></td>
                            <td class="bab"><?php echo $q->bab; ?></td>
                            <td class="page"><?php echo $q->page; ?></td>
                            <td class="trans_arabic"><?php echo $q->trans_arabic; ?></td>
                            <td class="trans_english"><?php echo $q->trans_english; ?></td>
                            <td class="trans_malay"><?php echo $q->trans_malay; ?></td>
                            <td class="delete_button"><a href="<?php echo Request::$BASE_URL; ?>index.php/adminUnlinkManuscript/<?php echo $parameters[1]; ?>/<?php echo $q->id; ?>" class="btn btn-danger btn-block">Unlink</a></td>
                       </tr>    
                       <?php endforeach; } ?>
                    </table>
                    </form>
                </div>
            </div>
            <!-- Manuscript List Ends -->

            <hr>

            <div class="row">
                <div class="col-md-4"><h3>Scientific Article List</h3></div>
                <form action="<?php echo Request::$BASE_URL; ?>index.php/linkArticle" method="POST">
                <div class="col-md-4">
                        <input type="hidden" name="keyword_id" value="<?php echo $parameters[1]; ?>" />
                        <select required name="article_id" class="select6 form-control">
                            <option value="">Link Scientific Article</option>

                            <?php if(isset($articles)){ foreach($articles as $h){ ?>
                                <option value="<?php echo $h->id ?>"><?php echo $h->name.">".$h->url; ?></option>
                            <?php }} ?>
                        </select>
                </div>
                <div class="col-md-2">
                        <input type="submit" class="btn btn-block btn-success" value="Link Scientific Article" />
                </div>
                </form>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <form action="<?php echo Request::$BASE_URL; ?>index.php/post" method="POST">
                    <table class="table table-bordered table-striped ">
                        <tr>
                            <th>#</th>
                            <th>Article Name / Title</th>
                            <th>Article Author / Publisher</th>
                            <th>Article URL</th>
                            <th></th>
                        </tr>
                       <?php if(isset($article[0]->id)){ $x=1; foreach ($article as $q): ?>
                       <tr data-id="<?php echo $q->id; ?>">
                            <td><?php echo $x; $x++; ?></td>
                             <td class="name"><?php echo $q->name; ?></td>
                            <td class="author"><?php echo $q->author; ?></td>
                            <td class="url"><?php echo $q->url; ?></td>
                            <td class="delete_button"><a href="<?php echo Request::$BASE_URL; ?>index.php/adminUnlinkArticle/<?php echo $parameters[1]; ?>/<?php echo $q->id; ?>" class="btn btn-danger btn-block">Unlink</a></td>
                       </tr>    
                       <?php endforeach; } ?>
                    </table>
                    </form>
                </div>
            </div>
            <!-- Article List Ends -->

            <hr>
            <div class="row">
                <div class="col-md-4"><h3>Synonyms List</h3></div>
                <div class="col-md-4">
                    <form action="<?php echo Request::$BASE_URL; ?>index.php/linkSynonym" method="POST">
                        <input type="hidden" name="keyword_id_1" value="<?php echo $parameters[1]; ?>" />
                        <select required name="keyword_id_2" class="select2 form-control">
                            <option value="">Link Keywords</option>
                            
                        </select>
                        <input type="submit" class="btn btn-block btn-success" value="Link Keyword as Synonym" />
                    </form>
                </div>
                <div class="col-md-4">
                    <button type="button" data-toggle="modal" data-target="#addSyn" class="btn btn-primary btn-block">Add NEW Keyword and Link as Synonym</button>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <form action="<?php echo Request::$BASE_URL; ?>index.php/post" method="POST">
                    <table class="table table-bordered table-striped ">
                        <tr>
                            <th>#</th>
                            <th>Keyword</th>
                            <th>Quran</th>
                            <th></th>
                            <th></th>
                        </tr>
                       <?php if($synonyms){ $x=1; foreach ($synonyms as $q): ?>
                       <tr data-id="<?php echo $q->id; ?>">
                            <td><?php echo $x; $x++; ?></td>
                            <td class="keyword"><?php echo $q->keyword; ?></td>
                            <td class="quran"><?php echo $q->quran; ?></td>
                            <td class="edit_button"><a href="<?php echo Request::$BASE_URL; ?>index.php/adminEditKeywords/<?php echo $q->id; ?>" class="btn btn-success btn-block">Manage</a></td>
                            <td class="delete_button"><a href="<?php echo Request::$BASE_URL; ?>index.php/adminUnlinkSynonyms/<?php echo $q->id; ?>/<?php if(isset($parameters[1])){ echo $parameters[1];} ?>" class="btn btn-danger btn-block">Unlink</a></td>
                            
                       </tr>    
                       <?php endforeach; } ?>
                    </table>
                    </form>
                </div>
            </div>

        </div>
        <!-- /#page-wrapper -->

        <!-- Modal -->
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
                <input type="hidden" name="linked_to" id="linked_to" value="<?php echo $parameters[1]; ?>" />
                <input type="text" required name="keyword" class="form-control" placeholder="Synonym">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Add</button>
              </div>
              </form>
            </div>
          </div>
        </div>
        <!-- Modal -->


    </div>
    <!-- /#wrapper -->