@extends('layouts.app')

@section('content')
<div class="container">
<h1>Antrian Pesanan</h1>

    <form action="{{ route('antrian.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nama_pelanggan">Nama Pelanggan</label>
            <input type="text" class="form-control" id="nama_pelanggan" name="nama_pelanggan">
        </div>
        <div class="form-group">
            <label for="jenis_mobil">Jenis Mobil</label>
            <input type="text" class="form-control" id="jenis_mobil" name="jenis_mobil">
        </div>
        <div class="form-group">
            <label for="warna">Warna</label>
            <input type="text" class="form-control" id="warna" name="warna">
        </div>
        <button type="submit" class="btn btn-primary">Tambahkan ke Antrian</button>
    </form>
    
    <hr>
    
    <h3>Daftar Antrian</h3>
    
    <table class="table">
        <thead>
            <tr>
                <th>Nama Pelanggan</th>
                <th>Jenis Mobil</th>
                <th>Warna</th>
                <th>Klasifikasi</th>
                <th>Waktu Pesanan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($antrian as $pesanan)
                <tr>
                    <td>{{ $pesanan->nama_pelanggan }}</td>
                    <td>{{ $pesanan->jenis_mobil }}</td>
                    <td>{{ $pesanan->warna }}</td>
                    <td>{{ $pesanan->klasifikasi }}</td>
                    <td>{{ $pesanan->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection