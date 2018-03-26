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

        if(optionValue > 0) {
            let optHtml = '<tr id="'+optionValue+'"><td>'+optionLabel+'</td><td>'+optionValueLabel+'</td><td><a onclick="removeParent('+optionValue+')" class="btn btn-danger">Remove</a><input type="hidden" name="options[]" value="'+option+';'+optionValue+'" /></td></tr>';
            $('#data-option').append(optHtml);
        } else {
            alert('Please select option value');
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

  function formatNumber(elem) {
      s = elem.val();
      var parts = s.split(/,/)
        , spaced = parts[0]
             .split('').reverse().join('') // Reverse the string.
             .match(/\d{1,3}/g).join(' ') // Join groups of 3 digits with spaces.
             .split('').reverse().join(''); // Reverse it back.
      return elem.val(spaced + (parts[1] ? ','+parts[1] : '')); // Add the fractional part.
    }

    function formatAmountNoDecimals( number ) {
        var rgx = /(\d+)(\d{3})/;
        while( rgx.test( number ) ) {
            number = number.replace( rgx, '$1' + '.' + '$2' );
        }
        return number;
    }

function formatAmount( elem ) {
    number = elem.val();

    // remove all the characters except the numeric values
    number = number.replace( /[^0-9]/g, '' );

    // set the default value
    if( number.length == 0 ) number = "0.00";
    else if( number.length == 1 ) number = "0.0" + number;
    else if( number.length == 2 ) number = "0." + number;
    else number = number.substring( 0, number.length - 2 ) + '.' + number.substring( number.length - 2, number.length );

    // set the precision
    number = new Number( number );
    number = number.toFixed( 2 );    // only works with the "."

    // change the splitter to ","
    number = number.replace( /\./g, ',' );

    // format the amount
    x = number.split( ',' );
    x1 = x[0];
    x2 = x.length > 1 ? ',' + x[1] : '';

    var rgx = /(\d+)(\d{3})/;
    while( rgx.test( x1 ) ) {
        x1 = x1.replace( rgx, '$1' + '.' + '$2' );
    }

    elem.val( x1 + x2);
}

  function removeParent(optValue) {
    $('#'+optValue).remove();
  }
</script>

<script src="{{asset('lte')}}/bower_components/select2/dist/js/select2.full.min.js"></script>
<script type="text/javascript">
    $('.select2').select2()
</script>