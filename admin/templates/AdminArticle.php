
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
                    <h1 class="page-header">Manage Scientific Article</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- Page Header -->

            <form action="<?php echo Request::$BASE_URL; ?>index.php/post" method="POST">
                <input type="hidden" name="table" value="scientific_article">
            <div class="row">
                <div class="col-md-6">
                    <label> Article Name / Title
                        <input type="text" required name="name" class="form-control" placeholder="Article Name / Title">
                    </label>

                    <label> Article Author / Publisher
                        <input type="text" name="author" class="form-control" placeholder="Article Author / Publisher">
                    </label>

                    <label> Abstract
                        <textarea class="form-control" name="abstract" rows="5"></textarea>
                    </label>
                    
                </div>

                <div class="col-md-6">
                   <label> Article URL
                        <input type="text" required name="url" class="form-control" placeholder="Article URL">
                    </label>

                    <label> Disease 1
                        <input type="text" required name="disease_1" class="form-control" placeholder="Disease 1">
                    </label>

                    <label> Disease 2
                        <input type="text" required name="disease_2" class="form-control" placeholder="Disease 2">
                    </label>

                    <label> Concept
                        <textarea class="form-control" name="concept" rows="5"></textarea>
                    </label>

                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <input type="submit" name="submit" class="btn btn-success btn-block" value="Add Article">
                </div>
            </div>
            </form>
            
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
            <?php Pagination::pagesBlock("scientific_article",30,Request::$BASE_URL."index.php/adminArticle"); ?>
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->