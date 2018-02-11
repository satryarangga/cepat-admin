<script src="{{asset('lte')}}/bower_components/select2/dist/js/select2.full.min.js"></script>
<script type="text/javascript">
    $('.select2').select2()
</script>

<script type="text/javascript">
	$('#product-list').change(function() {
		let val = $(this).val();
		let ori_price = $('#ori_price_'+val).val();
		$('#ori_price').val(moneyFormat(ori_price));
	});

	$('#product-list-edit').change(function() {
		let val = $(this).val();
		let ori_price = $('#edit_ori_price_'+val).val();
		$('#edit_ori_price').val(moneyFormat(ori_price));
	});

	function moneyFormat(num) {
        return num.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
    }

    function formatMoney(elem) {
        var n = parseInt(elem.val().replace(/\D/g, ''), 10);

        if (isNaN(n)) {
            elem.val('0');
        } else {
            elem.val(n.toLocaleString());
        }
   }
</script>