<script src="{{asset('lte')}}/bower_components/fastclick/lib/fastclick.js"></script>
<script src="{{asset('lte')}}/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script>
  $(function () {
    //bootstrap WYSIHTML5 - text editor
    $('.textarea').wysihtml5();

    $('input[name=has_variant]').click(function(){
        let val = $(this).val();

        if(val == 0) {
            $('#image-cont').show();
        } else {
            $('#image-cont').hide();
        }
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

<script src="{{asset('lte')}}/bower_components/select2/dist/js/select2.full.min.js"></script>
<script type="text/javascript">
    $('.select2').select2()
</script>