<script type="text/javascript">
	function submitSize(elem) {
		let size = $(elem).find('.size').val();
		let qty = $(elem).find('.qty').val();
		let valid = true;
		console.log(size);
		if(!size) {
			$(elem).find('.size-error').show();
			valid = false
		}

		if(!qty) {
			$(elem).find('.qty-error').show();
			valid = false
		}

		return valid;
	}

	function changeStatusSize(elem, status, variantId, sizeName) {
		let labelConfirm = (status == 1) ? 'activate' : 'deactivate';
		let confirmed = confirm('You will '+labelConfirm+' size '+sizeName+', continue?');
		if(confirmed) {
			$.ajax({
				method: 'GET',
				data: {"variant_id":variantId, "status":status},
				url: '{{route("ajax.changeStatusSizeVariant")}}',
				success: function(result) {
					var buttonStatus = [];
					if(status == 1) {
						var labelStatus = 'Active';
						buttonStatus.push('<a onclick="changeStatusSize($(this), 0, '+variantId+', \''+sizeName+'\')" class="btn btn-danger">Deactivate</a>');
					} else {
						var labelStatus = 'Not Active';
						buttonStatus.push('<a onclick="changeStatusSize($(this), 1, '+variantId+', \''+sizeName+'\')" class="btn btn-success">Activate</a>');
					}

					buttonStatus.push('<a onclick="deleteSize($(this), '+variantId+', \''+sizeName+'\')" class="btn btn-warning">Delete</a>');
					button = buttonStatus.join(" ");

					$(elem).parent().parent().find('.status').html(labelStatus);
					$(elem).parent().parent().find('.buttonStatus').html(button);
				}
			});
		}
	}

	function deleteSize(elem, variantId, sizeName) {
		let confirmed = confirm('You will delete size '+sizeName+', continue?');
		if(confirmed) {
			$.ajax({
				method: 'GET',
				data: {"variant_id":variantId},
				url: '{{route("ajax.deleteSizeVariant")}}',
				success: function(result) {
					let className = $(elem).parent().parent().attr('class');
					let currentTotal = $('#color-'+className).find('.total-color').html();
					let newTotal = parseInt(currentTotal) - 1;
					if(newTotal < 1) {
						$('#color-'+className).html('');
					} else {
						$('#color-'+className).find('.total-color').html(""+newTotal);
					}
					$(elem).parent().parent().html('');
				}
			});
		}
	}

	function deleteImage(elem, imageId) {
		let confirmed = confirm('You will delete one image, continue?');
		if(confirmed) {
			$.ajax({
				method: 'GET',
				data: {"image_id":imageId},
				url: '{{route("ajax.deleteImageVariant")}}',
				success: function(result) {
					let className = $(elem).parent().parent().attr('class');
					$(elem).parent().parent().html('');
				}
			});
		}
	}
</script>