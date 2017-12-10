<script src="{{ asset('lte') }}/bower_components/raphael/raphael.min.js"></script>
<script src="{{ asset('lte') }}/bower_components/morris.js/morris.min.js"></script>

<script type="text/javascript">
	$.ajax({
    	method: 'GET',
    	url: '{{route('ajax.graphSales')}}',
    	success: function(result) {
		  var bar = new Morris.Line({
		      element: 'revenue-chart',
		      resize: true,
		      data: JSON.parse(result),
		      lineColors: ['#1e88e5'],
		      xkey: 'period',
		      ykeys: ['totalSales'],
		      labels: ['Sales'],
		      hideHover: 'auto'
		    });    		
    	}
    });
</script>