<?php if($_SESSION["user_permission"] == "2"){ header("Location: ".Request::$BASE_URL); }?>
<body>
<style type="text/css">
    label{
        width:100%;
    }
</style>
    <div id="wrapper">

        <?php include_once("AdminNav.php"); ?>

        <div id="page-wrapper">
            
            <br><br>
            <div class="row">
                <div class="col-md-12"><h3>Prophetic Foods List</h3></div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <form action="<?php echo Request::$BASE_URL; ?>index.php/post" enctype="multipart/form-data" method="POST">
                    <table class="table table-bordered table-striped ">
                        <tr>
                            <th>#</th>
                            <th>Food</th>
                            <th>English Translation</th>
                            <th>Malay Translation</th>
                            <th>Arabic Translation</th>
                            <th>Image</th>
                            <th>Definition</th>
                            <th>Description</th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                       <?php if($food){ $x=1; foreach ($food as $f): ?>
                       <tr <?php if(!$f->is_approved){ ?>class="danger"<?php } ?> data-id="<?php echo $f->id; ?>">
                            <td><?php echo $x; $x++; ?></td>
                            <td class="food"><?php echo $f->food; ?></td>
                            <td class="trans_english"><?php echo $f->trans_english; ?></td>
                            <td class="trans_malay"><?php echo $f->trans_malay; ?></td>
                            <td class="trans_arabic"><?php echo $f->trans_arabic; ?></td>
                            <td class="food_image"><?php if(isset($f->path) && $f->path!=""){ ?><img src="<?php echo $f->path ?>" width="50px" /><?php } ?></td>
                            <td class="definition"><?php echo $f->definition; ?></td>
                            <td class="description"><?php echo $f->description; ?></td>
                            
                            <td class="edit_button"><button type="button" onClick="return editPropheticFood(this)" class="btn btn-success btn-block">Edit</button></td>
                    </form>
                            
                            <td><a href="<?php echo Request::$BASE_URL ?>index.php/adminEditPropheticFood/<?php echo $f->id; ?>" class="btn btn-block btn-primary">Additional<br/>Information</a></td>
                            <?php if(!$f->is_approved && $_SESSION['user_permission']==1){ ?>
                            <form onSubmit="return confirm('Are you sure you want to approve this?')" method="POST" action="<?php echo Request::$BASE_URL; ?>index.php/post">
                                <input type="hidden" name="table" value="prophetic_food" />
                                <input type="hidden" name="id" value="<?php echo $f->id; ?>" />
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
                       </tr>    
                       <?php endforeach; } ?>
                    </table>
                </div>
            </div>

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

            <br><br>
            <div class="row">
                <div class="col-md-12"><h3>Scientific Article List</h3></div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <form action="<?php echo Request::$BASE_URL; ?>index.php/post" method="POST">
                    <table class="table table-bordered table-striped ">
                        <tr>
                            <th>#</th>
                            <th>Article Title / Name</th>
                            <th>Article Author / Publisher</th>
                            <th>Article URL</th>
                            <th>Disease 1</th>
                            <th>Disease 2</th>
                            <th>Abstract</th>
                            <th>Concept</th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                       <?php if(isset($article)){ $x=1; foreach ($article as $q): ?>
                       <tr <?php if(!$q->is_approved){ ?>class="danger"<?php } ?> data-id="<?php echo $q->id; ?>">
                            <td><?php echo $x; $x++; ?></td>
                            <td class="name"><?php echo $q->name; ?></td>
                            <td class="author"><?php echo $q->author; ?></td>
                            <td class="url"><?php echo $q->url; ?></td>
                            <td class="d1"><?php echo $q->disease_1; ?></td>
                            <td class="d2"><?php echo $q->disease_2; ?></td>
                            <td class="abstract"><?php echo $q->abstract; ?></td>
                            <td class="concept"><?php echo $q->concept; ?></td>
                            <td class="edit_button"><button type="button" onClick="return editArticle(this)" class="btn btn-success btn-block">Edit</button></td>
                    </form>
                            
                            <td><a href="<?php echo Request::$BASE_URL ?>index.php/adminEditArticle/<?php echo $q->id; ?>" class="btn btn-block btn-primary">Additional<br/>Information</a></td>
                            <?php if(!$q->is_approved && $_SESSION['user_permission']==1){ ?>
                            <form onSubmit="return confirm('Are you sure you want to approve this?')" method="POST" action="<?php echo Request::$BASE_URL; ?>index.php/post">
                                <input type="hidden" name="table" value="scientific_article" />
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
                            <th>Type</th>
                            <th>Type ID</th>
                            <th>Information Title</th>
                            <th>Information</th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                       <?php if($additional_information){ $x=1; foreach ($additional_information as $q): ?>
                       <tr <?php if(!$q->is_approved){ ?>class="danger"<?php } ?> data-id="<?php echo $q->id; ?>">
                            <td><?php echo $x; $x++; ?></td>
                            <td class=""><?php echo $q->type; ?></td>
                            <td class=""><?php echo $q->type_id; ?></td>
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