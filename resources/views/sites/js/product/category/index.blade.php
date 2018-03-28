<script src="{{asset('js')}}/tree.jquery.js"></script>

<script type="text/javascript">

	$(function() {
	    $.getJSON(
		    '{{route("category.format-list")}}',
		    function(data) {
		        $('#tree1').tree({
		            data: data,
		            dragAndDrop: true,
		            autoOpen: true,
		            onCreateLi: function(node, $li) {
			            // Append a link to the jqtree-element div.
			            // The link has an url '#node-[id]' and a data property 'node-id'.
			            let status = '';
			            if(node.status == 1) {
			            	status = '<a onclick="return confirm(\'You will hide '+node.name+', continue\')" style="margin-left:20px;margin-bottom:10px;margin-top:10px"class="btn btn-danger" href="category/change-status/'+node.id+'">Hide</a>';
			            } else {
			            	status = '<a onclick="return confirm(\'You will show '+node.name+', continue\')" style="margin-left:20px;margin-bottom:10px;margin-top:10px"class="btn btn-success" href="category/change-status/'+node.id+'">Show</a>';
			            }
			            $li.find('.jqtree-element').append(
			                '<a style="margin-left:20px;margin-bottom:10px;margin-top:10px"class="btn btn-primary" href="category/'+node.id+'/edit">Edit</a><a onclick="return confirm(\'You will delete '+node.name+', continue\')" style="margin-left:20px;margin-bottom:10px;margin-top:10px"class="btn btn-danger" href="category/delete/'+node.id+'">Delete</a> '+status+' ');
			        }
		        });

		        $('#tree1').bind(
				    'tree.move',
				    function(event) {
				    	$.ajax({
				    		method: 'GET',
				    		url : '{{route("category.update-state")}}',
				    		data: {
				    				id:event.move_info.moved_node.id, 
				    				position:event.move_info.position,
				    				target:event.move_info.target_node.id
				    			},
				    		beforeSend: function() {
				    			$('.overlay').show();
				    			$('#success-category').hide();
				    		},
				    		success: function() {
				    			$('.overlay').hide();
				    			$('#success-category').show();
				    		}
				    	});
				    }
				);
		    }
		);
	});


</script>