@extends('layouts.app_sneat_blank')
@section('content')
<script type="text/javascript">
window.print();
</script>
<div class="container mt-5">
        <div class="d-flex justify-content-center row">
            <div class="col-md-8">
                <div class="p-3 bg-white rounded">
                    <div class="row">
                        <div class="col-md-12">
                            <h1 class="text-uppercase">KWITANSI PEMBAYARAN</h1>
                            <div class="billed"><span class="font-weight-bold">Nama Sekolah:</span><span class="ml-1">SMK NEGERI 1 KOTA BEKASI</span></div>
                            <div class="billed"><span class="font-weight-bold">Tanggal Tagihan:</span><span class="ml-1">{{ $pembayaran->tanggal_bayar->translatedFormat('d F Y')}}</span></div>
                            <div class="billed"><span class="font-weight-bold">Pembayaran ID:</span><span class="ml-1">#SMKN1-{{ $pembayaran->id }}</span></div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Tanggal Pembayaran</th>
                                        <th>Metode Bayar</th>
                                        <th>Jumlah Pembayaran</th>3
                                    </tr>
                                </thead>
                                <tbody>
                            <tr>
                                <td>{{ $pembayaran->tanggal_bayar->translatedFormat('d/m/y') }}</td>
                                <td>{{ formatRupiah($pembayaran->jumlah_dibayar) }}</td>
                                <td>{{ $pembayaran->metode_pembayaran }}</td>
                            </tr
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="text-right mb-3 font-italic">
                       <i> Terbilang: {{ ucwords(terbilang($pembayaran->jumlah_dibayar)) }}</i>
                    </div>
                    <div>
                        Bekasi, {{ $pembayaran->tanggal_bayar->translatedFormat('d F Y') }}
                        <br />
                        <br />
                        <br />
                        <u>{{ $pembayaran->user->name}}</u>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
