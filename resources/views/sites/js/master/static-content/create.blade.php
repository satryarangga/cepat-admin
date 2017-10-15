<script src="{{asset('lte')}}/bower_components/fastclick/lib/fastclick.js"></script>
<script src="{{asset('lte')}}/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script>
  $(function () {
    //bootstrap WYSIHTML5 - text editor
    $('.textarea').wysihtml5();

    $('input[name=type]').click(function(){
    	let val = $(this).val();

    	if(val == 1) {
    		$('#text-content').show();
    		$('#value-content').hide();
    	} else {
    		$('#text-content').hide();
    		$('#value-content').show();
    	}
    });
  });
</script>