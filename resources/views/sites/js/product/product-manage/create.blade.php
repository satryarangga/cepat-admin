<script src="{{asset('lte')}}/bower_components/fastclick/lib/fastclick.js"></script>
<script src="{{asset('lte')}}/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script>
  $(function () {
    //bootstrap WYSIHTML5 - text editor
    $('.textarea').wysihtml5();

    $('#cat_parent_id').change(function() {
    	let val = $(this).val();

    	$.ajax({
    		method: 'GET',
    		data: {"parent":val},
    		url: "{{route('ajax.getCategoryChild')}}",
    		success: function(result) {
    			let obj = jQuery.parseJSON(result);
    			let opt = [];
    			opt.push("<option>Choose Category Child</option>");
    			$.each(obj, function(key,value) {
    			  opt.push('<option value="'+value.id+'">'+value.name+'</option>');
    			});
    			let all = opt.join(" ");
    			$('#cat_child_container').show();
    			$('#cat_child_id').html(all);
    		}
    	});
    });

  });

  function formatMoney(elem) {
        var n = parseInt(elem.val().replace(/\D/g, ''), 10);

        if (isNaN(n)) {
            elem.val('0');
        } else {
            elem.val(n.toLocaleString());
        }
   }
</script>