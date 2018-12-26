<?php if(isset($_GET['search'])){$search=$_GET['search'];}else{$search="";} ?>
<?php //$quran=array(); if($results){ foreach($results as $result){ if(!in_array($result->id, $quran)){ $quran[]=$result->id; }}} $count=count($quran); ?>
<?php if(isset($quran)){  $nQuran=count($quran); } else{$nQuran= "0";} ?>
<?php if(isset($hadiths)){  $nHadith=count($hadiths); } else{$nHadith= "0";} ?>
<?php if(isset($manuscripts)){  $nManu=count($manuscripts); } else{$nManu= "0";} ?>
<?php if(isset($articles)){  $nArticle=count($articles); } else{$nArticle= "0";} ?>
<?php $nTotal=$nQuran+$nHadith+$nManu+$nArticle; ?>

<?php include_once('TopNav.php'); ?>

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
			  <h1>We found <small><?php echo $nTotal; ?> results</small></h1>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			
		</div>
	</div>

	<div class="row">

		<div class="col-md-2">

			<ul class="list-group">
			  <li class="list-group-item active" id="allLink">
			    <span class="badge"><?php echo $nTotal; ?></span>
			    <a class="link" style="color:#000;" href="javascript:void(0)" onClick="return showAll()">All</a>
			  </li>
			  <li class="list-group-item" id="quranLink">
			    <span class="badge"><?php echo $nQuran; ?></span>
			    <a class="link" style="color:#000;" href="javascript:void(0)" onClick="return showQuran()">Quran</a>
			  </li>
			  <li class="list-group-item" id="hadithLink">
			    <span class="badge"><?php echo $nHadith; ?></span>
			    <a class="link" style="color:#000;" href="javascript:void(0)" onClick="return showHadith()">Hadith</a>
			  </li>
			  <li class="list-group-item" id="manuLink">
			    <span class="badge"><?php echo $nManu; ?></span>
			    <a class="link" style="color:#000;" href="javascript:void(0)" onClick="return showManuscript()">Manuscript</a>
			  </li>
			  <li class="list-group-item" id="articleLink">
			    <span class="badge"><?php echo $nArticle; ?></span>
			    <a class="link" style="color:#000;" href="javascript:void(0)" onClick="return showArticle()">Scientific Article</a>
			  </li>
			</ul>
		</div>

		<div class="col-md-7">
			
			<?php if(isset($prophetic_food) && $prophetic_food->food!=""){ ?>
			<!-- Prophetic Food Description -->
			  <h1><?php echo $prophetic_food->food; ?></h1>
			  <hr>

			  <?php if(isset($prophetic_food->def_title) && $prophetic_food->def_title!="" && $prophetic_food->def_title!="NULL"){ ?>
				  <h3><?php echo $prophetic_food->def_title; ?></h3>
			  <?php }else{ ?>
			  	<h3>Definition</h3>
			  <?php } ?>
			  
			  <hr>
			  <p><?php echo $prophetic_food->definition; ?></p>


			  <?php if(isset($prophetic_food->desc_title) && $prophetic_food->desc_title!="" && $prophetic_food->desc_title!="NULL"){ ?>
				  <h3><?php echo $prophetic_food->desc_title; ?></h3>
			  <?php }else{ ?>
			  	<h3>Description</h3>
			  <?php } ?>
			  

			  <hr>
			  <p><small><?php echo $prophetic_food->description; ?></small></p>
			<!-- Prophetic Food Description -->
			<?php } ?>

			<div id="all">
				<ol class="breadcrumb">
					<li class="active">Top Quran Results</li>
					<li><a class="link" href="javascript:void(0)" onClick="return showQuran()">View All</a></li>
				</ol>
				<?php if(isset($quran)){ $cc=0; foreach($quran as $result){ $cc++; ?>
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-default">
						  <div class="panel-heading text-center">
						    <h3 class="panel-title"><?php echo $result->verse." : ".$result->surah->id." ".$result->surah->surah." | ".$result->surah->trans_english; ?></h3>
						  </div>
						  <div class="panel-body">
						  	<div class="row">
						    	<div class="col-md-2">
						    		Ayat
						    	</div>
						    	<div class="col-md-10">
						    		<?php echo $result->ayat; ?>
						    	</div>
						    </div>
						    <hr>

						    <div class="row">
						    	<div class="col-md-2">
						    		English Translation
						    	</div>
						    	<div class="col-md-10">
						    		<?php echo $result->trans_english; ?>
						    	</div>
						    </div>
						    <hr>
						    <div class="row">
						    	<div class="col-md-2">
						    		Malay Translation
						    	</div>
						    	<div class="col-md-10">
						    		<?php echo $result->trans_malay; ?>
						    	</div>
						    </div>
						    <hr>
						    <div class="row">
						    	<div class="col-md-4 col-md-offset-8">
						    		<a  target="_blank" href="<?php echo Request::$BASE_URL ?>index.php/page?type=quran&id=<?php echo $result->id; ?>" class="btn btn-block btn-default link">Details</a>
						    	</div>
						    </div>

						  </div>
						</div>
					</div>
				</div>
				<!-- Result Item -->
				<?php if($cc==5){break;} } } ?>

				<!-- Quran Section Ends -->


				<!-- Hadith Section Begins -->

				<ol class="breadcrumb">
					<li class="active">Top Hadith Results</li>
					<li><a class="link" href="javascript:void(0)" onClick="return showHadith()">View All</a></li>
				</ol>

				<?php if(isset($hadiths)){ $cc=0; foreach($hadiths as $result){ $cc++; ?>
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-default">
						  <div class="panel-heading text-center">
						    <h3 class="panel-title"><?php echo $result->kitab." > ".$result->bab." > ".$result->vol." : ".$result->page." | ".$result->hadith_no; ?></h3>
						  </div>
						  <div class="panel-body">
						  	<div class="row">
						    	<div class="col-md-2">
						    		Hadith
						    	</div>
						    	<div class="col-md-10">
						    		<?php echo $result->trans_arabic; ?>
						    	</div>
						    </div>
						    <hr>

						    <div class="row">
						    	<div class="col-md-2">
						    		English Translation
						    	</div>
						    	<div class="col-md-10">
						    		<?php echo $result->trans_english; ?>
						    	</div>
						    </div>
						    <hr>
						    <div class="row">
						    	<div class="col-md-2">
						    		Malay Translation
						    	</div>
						    	<div class="col-md-10">
						    		<?php echo $result->trans_malay; ?>
						    	</div>
						    </div>
						    <hr>
						    <div class="row">
						    	<div class="col-md-4 col-md-offset-8">
						    		<a target="_blank" href="<?php echo Request::$BASE_URL ?>index.php/page?type=hadith&id=<?php echo $result->id; ?>" class="btn btn-block btn-default link">Details</a>
						    	</div>
						    </div>


						  </div>
						</div>
					</div>
				</div>
				<!-- Result Item -->
				<?php if($cc==5){break;} } } ?>

				<!-- Hadith Section Ends -->


				<!-- Manuscript Section Begins -->

				<ol class="breadcrumb">
					<li class="active">Top Manuscript Results</li>
					<li><a class="link" href="javascript:void(0)" onClick="return showManuscript()">View All</a></li>
				</ol>

				<?php if(isset($manuscripts)){ $cc=0; foreach($manuscripts as $result){ $cc++; ?>
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-default">
						  <div class="panel-heading text-center">
						    <h3 class="panel-title"><?php echo $result->manuscript_no." > ".$result->bab." > ".$result->page; ?></h3>
						  </div>
						  <div class="panel-body">
						  	<div class="row">
						    	<div class="col-md-2">
						    		Original Text
						    	</div>
						    	<div class="col-md-10">
						    		<?php echo $result->trans_arabic; ?>
						    	</div>
						    </div>
						    <hr>

						    <div class="row">
						    	<div class="col-md-2">
						    		English
						    	</div>
						    	<div class="col-md-10">
						    		<?php echo $result->trans_english; ?>
						    	</div>
						    </div>
						    <hr>
						    <div class="row">
						    	<div class="col-md-2">
						    		Malay
						    	</div>
						    	<div class="col-md-10">
						    		<?php echo $result->trans_malay; ?>
						    	</div>
						    </div>
						    <hr>
						    <div class="row">
						    	<div class="col-md-4 col-md-offset-8">
						    		<a target="_blank" href="<?php echo Request::$BASE_URL ?>index.php/page?type=manuscript&id=<?php echo $result->id; ?>" class="btn btn-block btn-default link">Details</a>
						    	</div>
						    </div>


						  </div>
						</div>
					</div>
				</div>
				<!-- Result Item -->
				<?php if($cc==5){break;} } } ?>

				<!-- Manuscript Section Ends -->

				<!-- Article Section Begins -->

				<ol class="breadcrumb">
					<li class="active">Top Scientific Article Results</li>
					<li><a class="link" href="javascript:void(0)" onClick="return showArticle()">View All</a></li>
				</ol>

				<?php if(isset($articles)){ $cc=0; foreach($articles as $result){ $cc++; ?>
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-default">
						  <div class="panel-heading text-center">
						    <h3 class="panel-title">
						    	<a class="link" target="_blank" href="<?php echo $result->url; ?>">
						    		<?php echo $result->disease_1." > ".$result->disease_2." > ".$result->name; ?>
						    	</a>
						    </h3>
						  </div>
						  <div class="panel-body">
						  	<div class="row">
						    	<div class="col-md-2">
						    		Article Author / Published
						    	</div>
						    	<div class="col-md-10">
						    		<?php echo $result->author; ?>
						    	</div>
						    </div>
						    <hr>

						    <div class="row">
						    	<div class="col-md-2">
						    		Abstract Content
						    	</div>
						    	<div class="col-md-10">
						    		<?php 
						    		if(strlen($result->abstract)>300){
						    			echo substr($result->abstract, 0,300)."...";
						    		}else{
						    			echo $result->abstract;
						    		}
						    		?>
						    	</div>
						    </div>

						    <div class="row">
						    	<div class="col-md-2">
						    		Concept
						    	</div>
						    	<div class="col-md-10">
						    		<?php 
						    		if(strlen($result->concept)>300){
						    			echo substr($result->concept, 0,300)."...";
						    		}else{
						    			echo $result->concept;
						    		}
						    		?>

						    	</div>
						    </div>
						    
						    <hr>
						    <div class="row">
						    	<div class="col-md-4 col-md-offset-8">
						    		<a target="_blank" href="<?php echo Request::$BASE_URL ?>index.php/page?type=scientific_article&id=<?php echo $result->id; ?>" class="btn btn-block btn-default link">Details</a>
						    	</div>
						    </div>


						  </div>
						</div>
					</div>
				</div>
				<!-- Result Item -->
				<?php if($cc==5){break;} } } ?>

				<!-- Article Section Ends -->

			</div>
			<!-- All ends -->

			<!-- **Quran DIV** -->
			<div id="quran">
				<?php if(isset($quran)){ foreach($quran as $result){ ?>
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-default">
						  <div class="panel-heading text-center">
						    <h3 class="panel-title"><?php echo $result->verse." : ".$result->surah->id." ".$result->surah->surah." | ".$result->surah->trans_english; ?></h3>
						  </div>
						  <div class="panel-body">
						  	<div class="row">
						    	<div class="col-md-2">
						    		Ayat
						    	</div>
						    	<div class="col-md-10">
						    		<?php echo $result->ayat; ?>
						    	</div>
						    </div>
						    <hr>

						    <div class="row">
						    	<div class="col-md-2">
						    		English Translation
						    	</div>
						    	<div class="col-md-10">
						    		<?php echo $result->trans_english; ?>
						    	</div>
						    </div>
						    <hr>
						    <div class="row">
						    	<div class="col-md-2">
						    		Malay Translation
						    	</div>
						    	<div class="col-md-10">
						    		<?php echo $result->trans_malay; ?>
						    	</div>
						    </div>
						    <hr>
						    <div class="row">
						    	<div class="col-md-4 col-md-offset-8">
						    		<a target="_blank" href="<?php echo Request::$BASE_URL ?>index.php/page?type=quran&id=<?php echo $result->id; ?>" class="btn btn-block btn-default link">Details</a>
						    	</div>
						    </div>

						  </div>
						</div>
					</div>
				</div>
				<!-- Result Item -->
				<?php } } ?>

				<!-- Quran Section Ends -->
			</div>
			<!-- **Quran DIV ends** -->

			<!-- **Hadith DIV** -->
			<div id="hadith">
				<?php if(isset($hadiths)){ foreach($hadiths as $result){ ?>
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-default">
						  <div class="panel-heading text-center">
						    <h3 class="panel-title"><?php echo $result->kitab." > ".$result->bab." > ".$result->vol." : ".$result->page." | ".$result->hadith_no; ?></h3>
						  </div>
						  <div class="panel-body">
						  	<div class="row">
						    	<div class="col-md-2">
						    		Hadith
						    	</div>
						    	<div class="col-md-10">
						    		<?php echo $result->trans_arabic; ?>
						    	</div>
						    </div>
						    <hr>

						    <div class="row">
						    	<div class="col-md-2">
						    		English Translation
						    	</div>
						    	<div class="col-md-10">
						    		<?php echo $result->trans_english; ?>
						    	</div>
						    </div>
						    <hr>
						    <div class="row">
						    	<div class="col-md-2">
						    		Malay Translation
						    	</div>
						    	<div class="col-md-10">
						    		<?php echo $result->trans_malay; ?>
						    	</div>
						    </div>
						    <hr>
						    <div class="row">
						    	<div class="col-md-4 col-md-offset-8">
						    		<a target="_blank" href="<?php echo Request::$BASE_URL ?>index.php/page?type=hadith&id=<?php echo $result->id; ?>" class="btn btn-block btn-default link">Details</a>
						    	</div>
						    </div>


						  </div>
						</div>
					</div>
				</div>
				<!-- Result Item -->
				<?php  } } ?>
			</div>
			<!-- **Hadith DIV Ends** -->

			<!-- **Manuscript DIV** -->
			<div id="manuscript">
				<?php if(isset($manuscripts)){  foreach($manuscripts as $result){  ?>
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-default">
						  <div class="panel-heading text-center">
						    <h3 class="panel-title"><?php echo $result->manuscript_no." > ".$result->bab." > ".$result->page; ?></h3>
						  </div>
						  <div class="panel-body">
						  	<div class="row">
						    	<div class="col-md-2">
						    		Original Text
						    	</div>
						    	<div class="col-md-10">
						    		<?php echo $result->trans_arabic; ?>
						    	</div>
						    </div>
						    <hr>

						    <div class="row">
						    	<div class="col-md-2">
						    		English
						    	</div>
						    	<div class="col-md-10">
						    		<?php echo $result->trans_english; ?>
						    	</div>
						    </div>
						    <hr>
						    <div class="row">
						    	<div class="col-md-2">
						    		Malay
						    	</div>
						    	<div class="col-md-10">
						    		<?php echo $result->trans_malay; ?>
						    	</div>
						    </div>
						    <hr>
						    <div class="row">
						    	<div class="col-md-4 col-md-offset-8">
						    		<a target="_blank" href="<?php echo Request::$BASE_URL ?>index.php/page?type=manuscript&id=<?php echo $result->id; ?>" class="btn btn-block btn-default link">Details</a>
						    	</div>
						    </div>


						  </div>
						</div>
					</div>
				</div>
				<!-- Result Item -->
				<?php } } ?>
			</div>
			<!-- **Manuscript DIV ends** -->

			<!-- **Article DIV** -->
			<div id="article">
				<?php if(isset($articles)){  foreach($articles as $result){ ?>
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-default">
						  <div class="panel-heading text-center">
						    <h3 class="panel-title">
						    	<a class="link" target="_blank" href="<?php echo $result->url; ?>">
						    		<?php echo $result->disease_1." > ".$result->disease_2." > ".$result->name; ?>
						    	</a>
						    </h3>
						  </div>
						  <div class="panel-body">
						  	<div class="row">
						    	<div class="col-md-2">
						    		Article Author / Published
						    	</div>
						    	<div class="col-md-10">
						    		<?php echo $result->author; ?>
						    	</div>
						    </div>
						    <hr>

						    <div class="row">
						    	<div class="col-md-2">
						    		Abstract Content
						    	</div>
						    	<div class="col-md-10">
						    		<?php 
						    		if(strlen($result->abstract)>300){
						    			echo substr($result->abstract, 0,300)."...";
						    		}else{
						    			echo $result->abstract;
						    		}
						    		?>
						    	</div>
						    </div>

						    <div class="row">
						    	<div class="col-md-2">
						    		Concept
						    	</div>
						    	<div class="col-md-10">
						    		<?php 
						    		if(strlen($result->concept)>300){
						    			echo substr($result->concept, 0,300)."...";
						    		}else{
						    			echo $result->concept;
						    		}
						    		?>

						    	</div>
						    </div>
						    
						    <hr>
						    <div class="row">
						    	<div class="col-md-4 col-md-offset-8">
						    		<a target="_blank" href="<?php echo Request::$BASE_URL ?>index.php/page?type=scientific_article&id=<?php echo $result->id; ?>" class="btn btn-block btn-default link">Details</a>
						    	</div>
						    </div>


						  </div>
						</div>
					</div>
				</div>
				<!-- Result Item -->
				<?php } } ?>
			</div>
			<!-- **Article DIV ends** -->

		</div>
		<!-- left side of search ends -->

		<div class="col-md-3">
			<?php if(isset($prophetic_food) && $prophetic_food->food!=""){ ?>
			<!-- Prophetic Food Panel -->
			<div id="rightPanel" class="panel panel-default">
				<div class="panel-body">
					<div class="food_heading">
						<i><?php echo $prophetic_food->food ?></i>
					</div>
					<div class="food_image">
						<?php if(isset($prophetic_food->path) && $prophetic_food->path!=""){ ?>
						<img src="<?php echo $prophetic_food->path ?>" width="100%" />
						<?php } ?>
					</div>
					<div class="food_heading">
						Translation
					</div>
					<div class="food_table">
						<table class="table table-striped table-responsive">
							<tr>
								<th>Scientific Term</th>
								<td><?php echo $prophetic_food->trans_english ?></td>
							</tr>
							<tr>
								<th>Arabic</th>
								<td><?php echo $prophetic_food->trans_arabic ?></td>
							</tr>
							<tr>
								<th>Bahasa Malaysia</th>
								<td><?php echo $prophetic_food->trans_malay ?></td>
							</tr>
						</table>
					</div>
					<div class="food_heading">
						Sources
					</div>
					<div class="food_table">
						<table class="table table-striped table-responsive">
							<tr>
								<th>Quran</th>
								<td>
									<?php if($nQuran>0){ ?>
									<a class="link" href="javascript:void(0)" onClick="return showQuran()">
										<?php echo $nQuran ?> Results
									</a>
									<?php }else{ ?>
									0 Results
									<?php } ?>
								</td>
							</tr>
							<tr>
								<th>Hadith</th>
								<td>
									<?php if($nHadith>0){ ?>
									<a class="link" href="javascript:void(0)" onClick="return showHadith()">
										<?php echo $nHadith ?> Results
									</a>
									<?php }else{ ?>
									0 Results
									<?php } ?>
								</td>
							</tr>
							<tr>
								<th>Manuscripts</th>
								<td>
									<?php if($nManu>0){ ?>
									<a class="link" href="javascript:void(0)" onClick="return showManuscript()">
										<?php echo $nManu ?> Results
									</a>
									<?php }else{ ?>
									0 Results
									<?php } ?>
								</td>
							</tr>
							<tr>
								<th>Scientific Articles</th>
								<td>
									<?php if($nArticle>0){ ?>
									<a class="link" href="javascript:void(0)" onClick="return showArticle()">
										<?php echo $nArticle ?> Results
									</a>
									<?php }else{ ?>
									0 Results
									<?php } ?>

								</td>
							</tr>
						</table>
					</div>

					<div class="food_heading">
						Nexus of Knowledge
					</div>
					<div class="food_table">
						<?php if(isset($addPf)){ ?>
						<table class="table table-striped table-responsive" >
							<?php foreach($addPf as $add){ ?>
							<tr class="text-center">
								<td>
									<u>
										<a class="link" target="_blank" href="<?php echo Request::$BASE_URL; ?>index.php/page?type=prophetic_food&id=<?php echo $prophetic_food->id; ?>&info_id=<?php echo $add->id; ?>">
											<?php echo $add->type_title; ?>
										</a>
									</u>
								</td>
							</tr>
							<?php } ?>
						</table>
						<?php } ?>
					</div>

					<div class="food_heading">
						Synonyms / Similar Prophetic Foods
					</div>
					<div class="food_synonyms">
						<?php if(isset($pfs) && count($pfs)>0){ foreach($pfs as $p){ ?>
							<a class="link" href="<?php echo $p['url']; ?>"><?php echo $p['name']; ?></a>,
						<?php }}else{echo "No Synonyms Found!";} ?>
					</div>
					<canvas id="viewport" width="300" height="400"></canvas>
				</div>
			</div>
			<!-- Prophetic Food Panel Ends here -->

			<?php } ?>
		</div>
		<!-- right side of search ends -->
	</div>
	<!-- main row ends -->
	

	
</div>
<!-- container ends -->
<script type="text/javascript">
$(document).ready(function(){
    var package = '<?php echo $_SESSION['package_id'];?>';
    if(package == 1){
        $(".link").attr("href", "#");
        $("a").on('click',function (e) {
           e.preventDefault();
           alert('Please Subscribe to a paid package for view links!');
        });
    }
});
</script>