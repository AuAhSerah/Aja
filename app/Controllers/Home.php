<?php

namespace App\Controllers;

use \App\Models\BerandaModel;

class Home extends BaseController
{
    private $beranda;
    public function __construct()
    {
        $this->beranda = new BerandaModel();
    }
    public function index()
    {
        $data = [
            'title' => 'Beranda'
        ];
        return view('beranda', $data);
    }
    public function showChartTransaksi()
    {
        $tahun = $this->request->getVar('tahun');
        $reportTrans = $this->beranda->reportTransaksi($tahun);
        $response = [
            'status' => false,
            'data' => $reportTrans
        ];
        echo json_encode($response);
    }
    public function showChartPembelian()
    {
        $tahun = $this->request->getVar('tahun');
        $reportPembeli = $this->beranda->reportPembelian($tahun);
        $response = [
            'status' => false,
            'data' => $reportPembeli
        ];
        echo json_encode($response);
    }
    public function showChartCustomer()
    {
        $tahun = $this->request->getVar('tahun');
        $reportCust = $this->beranda->reportCustomer($tahun);
        $response = [
            'status' => false,
            'data' => $reportCust
        ];
        echo json_encode($response);
    }
    public function showChartSupplier()
    {
        $tahun = $this->request->getVar('tahun');
        $reportSupp = $this->beranda->reportSupplier($tahun);
        $response = [
            'status' => false,
            'data' => $reportSupp
        ];
        echo json_encode($response);
    }
    public function container()
    {
        return view('container/index');
    }
    public function container1()
    {
        return view('container/tugas2');
    }
    public function about($nama = null, $umur = 0)
    {
        echo "Hi, nama saya adalah $nama. Usia saya $umur tahun.";
    }
}
