
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
                    <h1 class="page-header">Manage Prophetic Food</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- Page Header -->

            <form action="<?php echo Request::$BASE_URL; ?>index.php/post" onSubmit="return confirm('Are you sure you want to submit?')" enctype="multipart/form-data" method="POST">
                <input type="hidden" name="table" value="prophetic_food">
            <div class="row">
                <div class="col-md-6">
                    <label> Food
                    <input type="text" required name="food" class="form-control" placeholder="Prophetic Food">
                    </label>

                    <label> English Translation
                    <input type="text"  name="trans_english" class="form-control" placeholder="English Translation">
                    </label>

                    <label>
                        Image
                        <input type="file" name="path" />
                    </label>

                </div>

                <div class="col-md-6">

                    <label> Arabic Translation
                    <input type="text"  name="trans_arabic" class="form-control" placeholder="Arabic Translation">
                    </label>

                    <label> Malay Translation
                    <input type="text"  name="trans_malay" class="form-control" placeholder="Malay Translation">
                    </label>

                     <label> Description Title
                    <input required type="text"  name="desc_title" class="form-control" placeholder="Description Title">
                    </label>

                     <label> Definition Title
                    <input required type="text"  name="def_title" class="form-control" placeholder="Definition Title">
                    </label>
                    
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                     <label>
                        Description
                        <textarea id="description" name="description" placeholder="Description" class="form-control" rows="5"></textarea>
                    </label>

                    <label>
                        Definition
                        <textarea id="definition" name="definition" placeholder="Definition" class="form-control" rows="7"></textarea>
                    </label>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <input type="submit" name="submit" class="btn btn-success btn-block" value="Create Prophetic Food">
                </div>
            </div>
            </form>
            
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
                            <th>Definition Title</th>
                            <th>Description Title</th>
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
                            <td class="def_title"><?php echo $f->def_title; ?></td>
                            <td class="desc_title"><?php echo $f->desc_title; ?></td>
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
            <?php Pagination::pagesBlock("prophetic_food",30,Request::$BASE_URL."index.php/adminPropheticFood"); ?>
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
    <script type="text/javascript" src="<?php echo Request::$BASE_URL ?>ckeditor/ckeditor.js"></script>
<?php editor("description"); ?>
<?php editor("definition"); ?>