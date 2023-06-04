@extends('customer.layout')

@section('content')

<div class="container">
    <h3 class="mt-3">Transaction History</h3>
    <hr/>
    @foreach ($history as $data)
        
    
    <div class="card my-2">
        <div class="card-header">
            Order ID: {{ $data->order_id }}
        </div>
        <div class="card-body">
            <table class="table">
                <tr>
                    <td width="15%">Pembeli</td>
                    <td>: {{ $data->nama}}</td>
                </tr>
                <tr>
                    <td width="15%">Alamat Pengiriman</td>
                    <td>: {{ $data->alamat.", ". $data->desa_kelurahan.", ".$data->kecamatan.", ".$data->kabupaten_kota.", ".$data->provinsi." - ".$data->kodepos}}</td>
                </tr>
                <tr>
                    <td width="15%">Nomor HP</td>
                    <td>: {{ $data->no_hp}}</td>
                </tr>
            </table>
            <h5>Order Details</h5>
            <table class="table">
                <thead>
                    <tr>
                        <th width="50%">Items</th>
                        <th width="15%">Harga</th>
                        <th width="20%">Qty</th>
                        <th width="15%">Sub Total</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $total = 0;
                    @endphp
                    @foreach ($details as $item)

                        @if ($data->id == $item->transaction_id) 
                            
                            @php
                                
                                $total += $item->qty * $item->price;
                            @endphp 
                            <tr>
                                <td>{{ $item->nama_barang}}</td>
                                <td>Rp <span style="float:right">{{ number_format(($item->price),0,',','.')}}</span></td>
                                <td>{{ $item->qty }}</td>
                                <td>Rp <span style="float:right">{{ number_format(($item->qty * $item->price),0,',','.')}}</span></td>
                            </tr>
                            
                            @endif
                            
                    @endforeach
                    <tr style="font-weight: bold; border-top:2px solid #000">
                        <td colspan="3" align="right">Total :</td>
                        <td>Rp <span style="float:right">{{number_format(($total+ $data->ongkir),0,',','.')}}</span></td>
                    </tr>
                </tbody>
            </table>
            <div class="history-upload">

                @if ($data->bukti_transfer == null)
                <p>Status Pembayaran : <span class="badge bg-danger">Belum Ada Bukti Pembayaran</span></p>
                @elseif ($data->bukti_transfer->status == "acc")
                <p>Status Pembayaran : <span class="badge bg-success">Accept</span></p>
                @else
                <p>Status Pembayaran : <span class="badge bg-warning text-dark">Pending</span></p>
                @endif
                
                <a href="/transaction/upload_bukti_transfer/{{ $data->id }}" class="btn btn-info">Upload Bukti Transfer</a>
            </div>
        </div>
    </div>

    @endforeach
</div>
    
@endsection