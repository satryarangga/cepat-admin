<div>
    Hi {{$order->first_name}} {{$order->last_name}},
    <p>Pesanan anda, <b>{{$order->product_name}}</b>. Warna: <b>{{$order->color_name}}</b>. Ukuran: <b>{{$order->size_name}}</b></p>
    @if($status == 1)
    <p>Sudah dikirim dengan nomor resi : <b>{{$order->resi}}</b></p>
    @elseif($status == 2)
    <p>Sudah tiba dan diterima di tempat tujuan</p>
    @elseif($status == 3)
    <p>Gagal dikirimkan ke alamat pengiriman anda</p>
    @elseif($status == 4)
    <p>Sudah kami terima untuk proses retur dan akan kami proses</p>
    @endif	
    <p>Catatan Pengiriman : {{$order->shipping_notes}}</p>
    <p>Informasi lebih lanjut dapat anda dapatkan dengan menghubungi customer service kami</p>
    <p>Terima Kasih</p>
</div>