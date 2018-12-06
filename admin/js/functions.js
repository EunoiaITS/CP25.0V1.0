function editPropheticFood(x){

	var row=$(x).closest('tr');

	var food=row.children('.food');
	var english=row.children('.trans_english');
	var arabic=row.children('.trans_arabic');
	var malay=row.children('.trans_malay');
	var food_image=row.children('.food_image');
	var def_title=row.children('.def_title');
	var desc_title=row.children('.desc_title');
	var definition=row.children('.definition');
	var description=row.children('.description');
	var btn=row.children('.edit_button');

	id=row.attr('data-id');

	food.html('<input type="hidden" name="id" value="'+id+'" /><input type="hidden" name="table" value="prophetic_food" /><input type="text" class="form-control" required name="food" value="'+food.html()+'" />');
	english.html('<input type="text" class="form-control" required name="trans_english" value="'+english.html()+'" />');
	arabic.html('<input type="text" class="form-control" required name="trans_arabic" value="'+arabic.html()+'" />');
	malay.html('<input type="text" class="form-control" required name="trans_malay" value="'+malay.html()+'" />');
	food_image.html('<input type="file" name="path" />');
	def_title.html('<input type="text" class="form-control" required name="def_title" value="'+def_title.html()+'" />');
	desc_title.html('<input type="text" class="form-control" required name="desc_title" value="'+desc_title.html()+'" />');

	definition.html('<textarea id="defi" class="form-control" name="definition" >'+definition.html()+' </textarea>');
	description.html('<textarea id="descr" class="form-control" name="description" >'+description.html()+' </textarea>');
	btn.html('<input type="submit" value="Save" class="btn btn-success btn-block" />');



	CKEDITOR.replace( 'descr',{});
	CKEDITOR.replace( 'defi',{});
	function CKupdate(){
	    for ( instance in CKEDITOR.instances )
	        CKEDITOR.instances[instance].updateElement();
	}


}

function editQuran(x){

    var row=$(x).closest('tr');

    var ayat=row.children('.ayat');
    var english=row.children('.trans_english');
    var malay=row.children('.trans_malay');
    var btn=row.children('.edit_button');

    id=row.attr('data-id');

    ayat.html('<input type="hidden" name="id" value="'+id+'" /><input type="hidden" name="table" value="quran" /><textarea required name="ayat" class="form-control">'+ayat.html()+'</textarea>');
    english.html('<textarea required name="trans_english" class="form-control">'+english.html()+'</textarea>');
    malay.html('<textarea required name="trans_malay" class="form-control">'+malay.html()+'</textarea>');
    btn.html('<input type="submit" value="Save" class="btn btn-success btn-block" />');

}

function editZikir(x){

    var row=$(x).closest('tr');

    var zikir=row.children('.zikir');

    var btn=row.children('.edit_button');

    id=row.attr('data-id');

    zikir.html('<input type="hidden" name="id" value="'+id+'" /><input type="hidden" name="table" value="zikir" /><textarea required name="zikir" class="form-control">'+zikir.html()+'</textarea>');
    
    btn.html('<input type="submit" value="Save" class="btn btn-success btn-block" />');

}

function editHadith(x){

	var row=$(x).closest('tr');

	var kitab=row.children('.kitab');
	var bab=row.children('.bab');
	var vol=row.children('.vol');
	var page=row.children('.page');
	var hadith_no=row.children('.hadith_no');
	var arabic=row.children('.trans_arabic');
	var english=row.children('.trans_english');
	var malay=row.children('.trans_malay');
	var btn=row.children('.edit_button');

	id=row.attr('data-id');

	kitab.html('<input type="hidden" name="id" value="'+id+'" /><input type="hidden" name="table" value="hadith" /><input type="text" required name="kitab" class="form-control" value="'+kitab.html()+'" />');
	bab.html('<input type="text" class="form-control" required name="bab" value="'+bab.html()+'" />');
	vol.html('<input type="text" class="form-control" required name="vol" value="'+vol.html()+'" />');
	page.html('<input type="text" class="form-control" required name="page" value="'+page.html()+'" />');
	hadith_no.html('<input type="text" class="form-control" required name="hadith_no" value="'+hadith_no.html()+'" />');
	
	
	arabic.html('<textarea required name="trans_arabic" class="form-control">'+arabic.html()+'</textarea>');
	english.html('<textarea required name="trans_english" class="form-control">'+english.html()+'</textarea>');
	malay.html('<textarea required name="trans_malay" class="form-control">'+malay.html()+'</textarea>');
	btn.html('<input type="submit" value="Save" class="btn btn-success btn-block" />');

}

function editManuscript(x){

	var row=$(x).closest('tr');

	var manuscript_no=row.children('.manuscript_no');
	var bab=row.children('.bab');
	var page=row.children('.page');
	var image=row.children('.image');
	var arabic=row.children('.trans_arabic');
	var english=row.children('.trans_english');
	var malay=row.children('.trans_malay');
	var btn=row.children('.edit_button');

	id=row.attr('data-id');

	manuscript_no.html('<input type="hidden" name="id" value="'+id+'" /><input type="hidden" name="table" value="manuscript" /><input type="text" required name="manuscript_no" class="form-control" value="'+manuscript_no.html()+'" />');
	bab.html('<input type="text" class="form-control" required name="bab" value="'+bab.html()+'" />');
	page.html('<input type="text" class="form-control" required name="page" value="'+page.html()+'" />');
	image.html('<input type="file" class="form-control" name="path" />');
	
	
	arabic.html('<textarea required name="trans_arabic" class="form-control">'+arabic.html()+'</textarea>');
	english.html('<textarea required name="trans_english" class="form-control">'+english.html()+'</textarea>');
	malay.html('<textarea required name="trans_malay" class="form-control">'+malay.html()+'</textarea>');
	btn.html('<input type="submit" value="Save" class="btn btn-success btn-block" />');

}

function editArticle(x){

	var row=$(x).closest('tr');

	var name=row.children('.name');
	var author=row.children('.author');
	var url=row.children('.url');
	var d1=row.children('.d1');
	var d2=row.children('.d2');
	var concept=row.children('.concept');
	var abstract=row.children('.abstract');
	var btn=row.children('.edit_button');

	id=row.attr('data-id');

	name.html('<input type="hidden" name="id" value="'+id+'" /><input type="hidden" name="table" value="scientific_article" /><input type="text" required name="name" class="form-control" value="'+name.html()+'" />');
	url.html('<input type="text" class="form-control" required name="url" value="'+url.html()+'" />');
	d1.html('<input type="text" class="form-control" required name="disease_1" value="'+d1.html()+'" />');
	d2.html('<input type="text" class="form-control" required name="disease_2" value="'+d2.html()+'" />');
	abstract.html('<textarea required name="abstract" class="form-control">'+abstract.html()+'</textarea>');
	concept.html('<textarea required name="concept" class="form-control">'+concept.html()+'</textarea>');
	
	author.html('<input type="text" class="form-control" required name="author" value="'+author.html()+'" />');
	
	btn.html('<input type="submit" value="Save" class="btn btn-success btn-block" />');

}

function editInfo(x){

	var row=$(x).closest('tr');

	var type_title=row.children('.type_title');
	var information=row.children('.information');
	var btn=row.children('.edit_button');

	id=row.attr('data-id');

	type_title.html('<input type="hidden" name="id" value="'+id+'" /><input type="hidden" name="table" value="additional_information" /><textarea required name="type_title" class="form-control">'+type_title.html()+'</textarea>');
	information.html('<textarea id="inf" required name="information" class="form-control">'+information.html()+'</textarea>');
	btn.html('<input type="submit" value="Save" class="btn btn-success btn-block" />');

	CKEDITOR.replace( 'inf',{});
	function CKupdate(){
	    for ( instance in CKEDITOR.instances )
	        CKEDITOR.instances[instance].updateElement();
	}

}

function editTopic(x){

    var row=$(x).closest('tr');

    var title=row.children('.title');
    var description=row.children('.description');
    var btn=row.children('.edit_button');

    id=row.attr('data-id');

    title.html('<input type="hidden" name="id" value="'+id+'" /><input type="hidden" name="table" value="forum_topic" /><textarea required name="title" class="form-control">'+title.html()+'</textarea>');
    description.html('<textarea id="inf" required name="description" class="form-control">'+description.html()+'</textarea>');
    btn.html('<input type="submit" value="Save" class="btn btn-success btn-block" />');

    CKEDITOR.replace( 'inf',{});
    function CKupdate(){
        for ( instance in CKEDITOR.instances )
            CKEDITOR.instances[instance].updateElement();
    }

}

function replyComment(x){

    var row=$(x).closest('tr');

    var type_title=row.children('.type_title');
    var replytext=row.children('.reply');
    var btn=row.children('.edit_button');

    id=row.attr('data-id');
    replytext.html('<input type="hidden" name="comment_id" value="'+id+'" /><textarea id="inf"  name="reply" class="form-control">'+replytext.html()+'</textarea>');
    btn.html('<input type="submit" value="send" class="btn btn-primary btn-block" />');

    CKEDITOR.replace( 'inf',{});
    function CKupdate(){
        for ( instance in CKEDITOR.instances )
            CKEDITOR.instances[instance].updateElement();
    }

}

function editEvent(x){

    var row=$(x).closest('tr');

    var title=row.children('.title');
    var description=row.children('.description');
    var address=row.children('.address');
    var btn=row.children('.edit_button');

    id=row.attr('data-id');

    title.html('<input type="hidden" name="id" value="'+id+'" /><input type="hidden" name="table" value="events" /><textarea required name="title" class="form-control">'+title.html()+'</textarea>');
    description.html('<textarea id="inf" required name="description" class="form-control">'+description.html()+'</textarea>');
    address.html('<textarea required name="address" class="form-control">'+address.html()+'</textarea>');
    btn.html('<input type="submit" value="Save" class="btn btn-success btn-block" />');

    CKEDITOR.replace( 'inf',{});
    function CKupdate(){
        for ( instance in CKEDITOR.instances )
            CKEDITOR.instances[instance].updateElement();
    }

}

function addSyn(x){

	var row=$(x).closest('tr');
	id=row.attr('data-id');
	$("#linked_to").val(id);
}

function submitPropheticFood(x){
		$.ajax({
	  method: "POST",
	  url: "some.php",
	  data: { name: "John", location: "Boston" }
	})
	  .done(function( msg ) {
	    alert( "Data Saved: " + msg );
	  });
}

