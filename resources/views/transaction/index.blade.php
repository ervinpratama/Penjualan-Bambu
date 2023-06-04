@extends('layouts.app')

@section('title', 'Data Transaksi')

@section('contents')
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Data Transaksi</h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <form action="{{ route('exportPDF')}}" method="POST">
                    @method('POST')
                    @csrf
                    <div class="row">
                        <div class="col-md-8">
                            <input name="daterange" type="text" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary">Export Data</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>No</th>
                <th>Order ID</th>
                <th>Nama Lengkap</th>
                <th>No HP</th>
                <th>Alamat</th>
                <th>Provinsi</th>
                <th>Kab/Kota</th>
                <th>Kec</th>
                <th>Desa/Kel</th>
                <th>Kode POS</th>
                <th>Total</th>
                <th>Bukti Transfer</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
                
                @foreach ($transactions as $transaction)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $transaction->order_id }}</td>
                    <td>{{ $transaction->nama }}</td>
                    <td>{{ $transaction->no_hp }}</td>
                    <td>{{ $transaction->alamat }}</td>
                    <td>{{ $transaction->provinsi }}</td>
                    <td>{{ $transaction->kabupaten_kota }}</td>
                    <td>{{ $transaction->kecamatan }}</td>
                    <td>{{ $transaction->desa_kelurahan }}</td>
                    <td>{{ $transaction->kodepos }}</td>
                    <td>Rp {{ number_format($transaction->total, 0,',','.') }}</td>
                    <td>
                        
                        @if ($transaction->bukti_transfer != null)
                        <button data-gambar="{{ $transaction->bukti_transfer->gambar}}" type="button" class="lihat-bukti btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal">
                            Lihat Bukti Transfer
                          </button>
                        @else
                         <span class="badge badge-warning">Belum Ada Bukti Transfer</span>
                        @endif
                    </td>
                    <td>
                        @if ($transaction->bukti_transfer == null)
                        <span class="badge badge-danger">None</span>
                        @elseif($transaction->bukti_transfer->status == 'acc')
                         <span class="badge badge-success">Accept</span>
                        @else
                        <span class="badge badge-warning">Pending</span>
                        @endif
                    </td>
                    <td>
                        @if ($transaction->bukti_transfer != null && $transaction->bukti_transfer->status != 'acc')
                        <a href="/transaction/accept/{{$transaction->id}}" class="btn btn-success btn-sm">Accept</a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
  </div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Bukti Transfer</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" >
          <img src="" alt="" id="bukti" width="100%">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
@endsection
<!-- Bootstrap core JavaScript-->
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script>
$(document).ready(function(){
    $('.lihat-bukti').click(function(){
        let gambar = $(this).data('gambar')
        console.log(gambar);

        $('#bukti').attr('src', `bukti_transfer/${gambar}`)
    })
})
</script>
