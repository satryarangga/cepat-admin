<div>
    Hi {{$order->first_name}} {{$order->last_name}},
    <p>
        Kami ucapkan terima kasih karena pembayaran anda untuk order <b>{{$order->purchase_code}}</b> sebesar <b>{{moneyFormat($order->grand_total)}}</b> telah kami terima
    </p>
    <p>kami akan memberitahukan anda apabila barang pesanan anda sudah diproses</p>
    <p>Terima Kasih</p>
</div>