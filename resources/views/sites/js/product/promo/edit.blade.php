<script src="{{asset('lte')}}/bower_components/jquery-ui/ui/datepicker.js"></script>
<script src="{{asset('lte')}}/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<script type="text/javascript">
    $(function() {
        $('.datepicker').datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            minDate: '0'
        });

        $('.timepicker').timepicker({
          showInputs: false,
          minuteStep: 1
        })
    })
</script>