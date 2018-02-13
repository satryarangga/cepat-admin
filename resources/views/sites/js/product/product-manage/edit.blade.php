<script src="{{asset('lte')}}/bower_components/fastclick/lib/fastclick.js"></script>
<script src="{{asset('lte')}}/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script>
  $(function () {

    $('.textarea').wysihtml5();

    $('input[name=has_variant]').click(function(){
        let val = $(this).val();

        if(val == 0) {
            $('#image-cont').show();
        } else {
            $('#image-cont').hide();
        }
    });

    $('#option').change(function() {
        let val = $(this).val();
        $('#option-value').html('<option>Select Value</option>');
        let opt = [];
        $.ajax({
            url: '{{route('ajax.getOptionValue')}}',
            data: {option_id:val},
            method: 'GET',
            success: function(result) {
                let obj = jQuery.parseJSON(result);
                $.each(obj, function(key,value) {
                    opt.push('<option value="'+value.id+'">'+value.name+'</option>');
              }); 
                let all = opt.join(" ");
                $('#option-value').html(all);
            }
        });
    });

    $('#add-option').click(function() {
        let option = $('#option').val();
        let optionLabel = $('#option option:selected').html();
        let optionValue = $('#option-value').val();
        let optionValueLabel = $('#option-value option:selected').html();

        let optHtml = '<tr id="'+optionValue+'"><td>'+optionLabel+'</td><td>'+optionValueLabel+'</td><td><a onclick="removeParent('+optionValue+')" class="btn btn-danger">Remove</a><input type="hidden" name="options[]" value="'+option+';'+optionValue+'" /></td></tr>';
        $('#data-option').append(optHtml);
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

  function removeParent(optValue) {
    $('#'+optValue).remove();
  }
</script>

<script src="{{asset('lte')}}/bower_components/select2/dist/js/select2.full.min.js"></script>
<script type="text/javascript">
    $('.select2').select2()
</script>