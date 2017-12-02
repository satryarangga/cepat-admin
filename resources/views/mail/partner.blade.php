<div>
    Hi {{$partner->store_name}},
    @if($type == 'reject')
        <p>Kami ingin memberitahukan bahwa permintaan anda untuk menjadi partner Cepat Cepat E-Commerce <b>DITOLAK</b> karena beberapa alasan</p>
        <p>Anda dapat menghubungi customer service kami untuk info lebih lanjut</p>
    @else
        <p>Selamat, kamu sudah menjadi partner dari Cepat Cepat E-Commerce.</p>
        <p>Berikut adalah detail untuk login ke dalam dashboard partner Cepat Cepat E-Commerce </p>
        <p>Username : {{$partner->username}}</p>
        <p>Password : {{$partner->password}}</p>
        <p>Silahkan klik link berikut untuk mengakses dashboard partner. <a href="{{route('home')}}">Dashboard Partner</a></p>
    @endif
</div>