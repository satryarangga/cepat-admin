<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">
  $(function() {
    $(document).ready(function() {
        let sender_province_id = $('#sender_province_id').val();
        getCity(sender_province_id, "sender");

        let receiver_province_id = $('#receiver_province_id').val();
        getCity(receiver_province_id, "receiver");
    });
    
    $( "#sender_province" ).autocomplete({
      source: "{{route('ajax.getProvince')}}",
      focus: function( event, ui ) {
        $( "#sender_province").val( ui.item.label );
        return false;
      },
      select: function( event, ui) {
        $('#sender_province_id').val(ui.item.value);

        getCity(ui.item.value, "sender");

        return false;

      }
    });

    $( "#receiver_province" ).autocomplete({
      source: "{{route('ajax.getProvince')}}",
      focus: function( event, ui ) {
        $( "#receiver_province").val( ui.item.label );
        return false;
      },
      select: function( event, ui) {
        $('#receiver_province_id').val(ui.item.value);

        getCity(ui.item.value, "receiver");

        return false;

      }
    });
  })

  function getCity(province_id, type) {
    $('#'+type+'_city_id').html("");
    $.ajax({
        method: 'GET',
        data: {"province": province_id},
        url: "{{route('ajax.getCity')}}",
        success : function(result) {
          let obj = jQuery.parseJSON(result);
          let opt = [];
          let oldCityId = (type == 'sender') ? '{{$sender_city_id}}' : '{{$receiver_city_id}}';
          opt.push("<option>Choose City</option>");
          $.each(obj, function(key,value) {
            let selected = '';
            if(oldCityId == value.id) {
                selected = 'selected';
            }
            opt.push('<option '+selected+' value="'+value.id+'">'+value.type+' '+value.name+'</option>');
          }); 
          let all = opt.join(" ");
          $('#'+type+'_city_id').html(all);
        }
     });
  }
</script>