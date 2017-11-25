@foreach($result as $key => $val)
@if($val->duration)
<script>

// Update the count down every 1 second
var x = setInterval(function() {

    // Get todays date and time
    var countDownDate = new Date("{{$val->end_on}}").getTime();
    var now = new Date().getTime();
    
    // Find the distance between now an the count down date
    var distance = countDownDate - now;
    
    // Time calculations for days, hours, minutes and seconds
    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    
    // Output the result in an element with id="demo"
    if(days > 0) {
        document.getElementById("countdown-{{$val->id}}").innerHTML = days + "d " + hours + "h "
        + minutes + "m " + seconds + "s ";
    } else if(hours > 0) {
        document.getElementById("countdown-{{$val->id}}").innerHTML = hours + "h "
        + minutes + "m " + seconds + "s ";
    } else if(minutes > 0) {
        document.getElementById("countdown-{{$val->id}}").innerHTML = hours + "h " + minutes + "m " + seconds + "s ";
    } else {
        document.getElementById("countdown-{{$val->id}}").innerHTML = seconds + "s ";
    }
    
    // If the count down is over, write some text 
    if (distance < 0) {
        clearInterval(x);
        document.getElementById("countdown-{{$val->id}}").innerHTML = "EXPIRED";
        window.location.href = "{{route('product-manage.expiredCountdown')}}";
    }
}, 1000);
</script>
@endif
@endforeach