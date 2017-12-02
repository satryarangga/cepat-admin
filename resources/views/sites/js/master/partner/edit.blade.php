<script src="{{asset('lte')}}/bower_components/jquery-ui/ui/datepicker.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
  $(function () {
    $(document).ready(function() {
        let province_id = $('#province_id').val();
        getCity(province_id);
    });

    $('.datepicker').datepicker({
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        changeYear: true,
        maxDate: '0'
    });

    $( "#province" ).autocomplete({
      source: "{{route('ajax.getProvince')}}",
      focus: function( event, ui ) {
        $( "#province").val( ui.item.label );
        return false;
      },
      select: function( event, ui) {
        $('#province_id').val(ui.item.value);

        getCity(ui.item.value);

        return false;

      }
    });
  });

  function getCity(province_id) {
    $('#city_id').html("");
    $.ajax({
        method: 'GET',
        data: {"province": province_id},
        url: "{{route('ajax.getCity')}}",
        success : function(result) {
            let obj = jQuery.parseJSON(result);
            let opt = [];
            let oldCityId = '{{$row->city_id}}';
            opt.push("<option>Choose City</option>");
            $.each(obj, function(key,value) {
                let selected = '';
                if(oldCityId == value.id) {
                    selected = 'selected';
                }
                opt.push('<option '+selected+' value="'+value.id+'">'+value.name+'</option>');
            }); 
            let all = opt.join(" ");
            $('#city_id').html(all);
        }
     });
  }
</script>