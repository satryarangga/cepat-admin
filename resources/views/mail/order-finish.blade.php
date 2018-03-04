<div>
    Hi {{$customer->first_name}} {{$customer->last_name}},
    <p>Berikut adalah rincian pemesanan anda</p>
    <p>Kode Pemesanan :<b>{{$orderHead->purchase_code}}</b></p>
    <p>Status Pemesanan :<b>{{($orderPayment->status == 0) ? 'Menunggu Pembayaran' : 'Pembayaran Telah Diterima'}}</b></p>
    <table>
    	<thead>
    		<tr>
    			<th>Produk</th>
    			<th>Jumlah</th>
    			<th>Harga Satuan</th>
    			<th>Subtotal</th>
    		</tr>
    		@foreach($orderItem as $key => $val)
    		<tr>
    			<td style="padding: 10px">{{$val->product_name}}</td>
    			<td style="padding: 10px">{{$val->qty}}</td>
    			<td style="padding: 10px">{{moneyFormat($val->product_price)}}</td>
    			<td style="padding: 10px">{{moneyFormat($val->subtotal)}}</td>
    		</tr>
    		@endforeach
    		<tr>
    			<td colspan="3" style="text-align: right;">Total Belanja</td>
    			<td>{{moneyFormat($orderHead->total_purchase)}}</td>
    		</tr>
    		<tr>
    			<td colspan="3" style="text-align: right;">Biaya Pengiriman</td>
    			<td>{{moneyFormat($orderHead->shipping_cost)}}</td>
    		</tr>
            @if($orderHead->paycode != 0)
            <tr>
                <td colspan="3" style="text-align: right;">Kode Unik</td>
                <td>{{moneyFormat($orderHead->paycode)}}</td>
            </tr>
            @endif
    		@if($orderHead->discount != 0)
    		<tr>
    			<td colspan="3" style="text-align: right;">Potongan Voucher</td>
    			<td>{{moneyFormat($orderHead->discount)}}</td>
    		</tr>
    		@endif
    		@if($orderHead->credit_used != 0)
    		<tr>
    			<td colspan="3" style="text-align: right;">Potongan Saldo Wallet</td>
    			<td>{{moneyFormat($orderHead->credit_used)}}</td>
    		</tr>
    		@endif
    	</thead>
    </table>
    <h2>Total Pembayaran : {{moneyFormat($orderHead->grand_total)}}</h2>
    <h3>Metode Pembayaran</h3>
    <p>
    	{{$orderPayment->payment_method_name}}<br />
    	{{$orderPayment->payment_method_desc}}
    </p>
    @if($orderPayment->status == 0)
    <p>Pemesanan yang belum dibayar setelah dua hari akan otomatis dibatalkan</p>
    @endif
    <p>Terima Kasih</p>
</div>