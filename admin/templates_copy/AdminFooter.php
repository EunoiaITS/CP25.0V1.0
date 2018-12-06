



    <!-- jQuery -->
    <script src="<?php echo Request::$BASE_URL; ?>vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo Request::$BASE_URL; ?>vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="<?php echo Request::$BASE_URL; ?>vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <!--<script src="<?php echo Request::$BASE_URL; ?>vendor/raphael/raphael.min.js"></script>
    <script src="<?php echo Request::$BASE_URL; ?>vendor/morrisjs/morris.min.js"></script>
    <script src="<?php echo Request::$BASE_URL; ?>data/morris-data.js"></script>-->

    <!-- Custom Theme JavaScript -->
    <script src="<?php echo Request::$BASE_URL; ?>dist/js/sb-admin-2.js"></script>

    <!-- Additional Functions -->
    <script src="<?php echo Request::$BASE_URL; ?>js/functions.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {

         $('.select2').select2({
  ajax: {
    url: "<?php echo Request::$BASE_URL; ?>index.php/selectKeyword",
    dataType: 'json',
    delay: 250,
    data: function (params) {
      return {
        q: params.term, // search term
        page: params.page
      };
    },
    processResults: function (data, params) {
      // parse the results into the format expected by Select2
      // since we are using custom formatting functions we do not need to
      // alter the remote JSON data, except to indicate that infinite
      // scrolling can be used
      params.page = params.page || 1;

      return {
        results: data,
        pagination: {
          more: (params.page * 30) < data.total_count
        }
      };
    },
    cache: true
  },
  escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
  minimumInputLength: 1,
   templateResult: function (repo) { return "<option id='" + repo.id + "'>" +repo.keyword+ "</option>" }, 
   // omitted for brevity, see the source of this page
    templateSelection: function (repo) { return repo.keyword} // omitted for brevity, see the source of this page
});


$('.select3').select2({
  placeholder: "Link Quran",
  allowClear: true
});

$('.select4').select2({
  placeholder: "Link Hadith",
  allowClear: true
});

$('.select5').select2({
  placeholder: "Link Manuscript",
  allowClear: true
});

$('.select6').select2({
  placeholder: "Link Scientific Article",
  allowClear: true
});


     });

 
</script>

</body>

</html>
