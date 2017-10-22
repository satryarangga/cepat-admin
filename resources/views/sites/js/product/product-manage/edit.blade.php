<script src="{{asset('lte')}}/bower_components/fastclick/lib/fastclick.js"></script>
<script src="{{asset('lte')}}/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script>
  $(function () {
    //bootstrap WYSIHTML5 - text editor

    $(document).ready(function(){
    	let val = $('#cat_parent_id').val();
    	getChild(val);
    });

    $('.textarea').wysihtml5();

    $('#cat_parent_id').change(function() {
    	let val = $(this).val();

    	getChild(val);
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

  function getChild(parent) {
  	$.ajax({
    		method: 'GET',
    		data: {"parent":parent},
    		url: "{{route('ajax.getCategoryChild')}}",
    		success: function(result) {
    			let obj = jQuery.parseJSON(result);
    			let opt = [];
    			let oldParentId = '{{$categoryMap->category_parent_id}}';
    			opt.push("<option>Choose Category Child</option>");
    			$.each(obj, function(key,value) {
    				let selected = '';
	              	if(oldParentId == value.id) {
	                    selected = 'selected';
	                }
    			  	opt.push('<option '+selected+' value="'+value.id+'">'+value.name+'</option>');
    			});
    			let all = opt.join(" ");
    			$('#cat_child_container').show();
    			$('#cat_child_id').html(all);
    		}
    	});
  }
</script>