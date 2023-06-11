<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;

class AntrianController extends Controller
{
    public function index()
    {
        $antrian = Pesanan::orderBy('created_at', 'asc')->get();

        return view('antrian.index', compact('antrian'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pelanggan' => 'required',
            'jenis_mobil' => 'required',
            'warna' => 'required', // Menambahkan validasi untuk fitur warna
        ]);

        $pesanan = Pesanan::create($request->all());

        // Klasifikasi menggunakan metode Naive Bayes Classifier
        $klasifikasi = $this->klasifikasiNaiveBayes($pesanan);

        $pesanan->klasifikasi = $klasifikasi;
        $pesanan->save();

        return redirect()->back()->with('success', 'Pesanan berhasil ditambahkan ke antrian.');
    }

    private function klasifikasiNaiveBayes($pesanan)
    {
        // Menghitung jumlah total data pesanan
        $totalData = Pesanan::count();

        // Menghitung jumlah pesanan berdasarkan jenis mobil
        $jumlahSedan = Pesanan::where('jenis_mobil', 'Sedan')->count();
        $jumlahSUV = Pesanan::where('jenis_mobil', 'SUV')->count();

        // Menghitung probabilitas prior
        $probabilitasSedan = $jumlahSedan / $totalData;
        $probabilitasSUV = $jumlahSUV / $totalData;

        // Menghitung likelihood untuk fitur warna
        $likelihoodWarnaSedan = $this->hitungLikelihood('Sedan', 'warna', $pesanan);
        $likelihoodWarnaSUV = $this->hitungLikelihood('SUV', 'warna', $pesanan);

        // Menghitung probabilitas posterior
        $probabilitasPosteriorSedan = $probabilitasSedan * $likelihoodWarnaSedan;
        $probabilitasPosteriorSUV = $probabilitasSUV * $likelihoodWarnaSUV;

        // Klasifikasi berdasarkan probabilitas posterior tertinggi
        if ($probabilitasPosteriorSedan > $probabilitasPosteriorSUV) {
            return 'Biasa';
        } elseif ($probabilitasPosteriorSUV > $probabilitasPosteriorSedan) {
            return 'Premium';
        } else {
            return 'Tidak Diketahui';
        }
    }

    private function hitungLikelihood($jenisMobil, $fitur, $pesanan)
    {
        // Menghitung jumlah pesanan dengan jenis mobil tertentu
        $jumlahPesanan = Pesanan::where('jenis_mobil', $jenisMobil)->count();

        // Menghitung jumlah pesanan dengan jenis mobil tertentu dan fitur yang sesuai
        $jumlahPesananFitur = Pesanan::where('jenis_mobil', $jenisMobil)->where($fitur, $pesanan->$fitur)->count();

        // Menghitung likelihood
        $likelihood = ($jumlahPesananFitur + 1) / ($jumlahPesanan + 2);

        return $likelihood;
    }
}