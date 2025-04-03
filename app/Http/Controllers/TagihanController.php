<?php

namespace App\Http\Controllers;

use App\Models\Tagihan as Model;
use App\Http\Requests\StoreTagihanRequest;
use App\Http\Requests\UpdateTagihanRequest;
use App\Models\Biaya;
use App\Models\Siswa as ModelsSiswa;
use App\Models\Tagihan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TagihanController extends Controller
{
    private $viewIndex = 'tagihan_index';
    private $viewCreate = 'tagihan_form';
    private $viewEdit = 'tagihan_form';
    private $viewShow = 'tagihan_show';
    private $routePrefix = 'tagihan';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->filled('q')) {
            $models = Model::with('user','siswa')->search($request->q)->paginate(50);
        }else{
            $models = Model::with('user','siswa')->latest()->paginate(50);
        }
 
        return view('tu.'.$this->viewIndex, [
            'models' => $models,
            'routePrefix' => $this->routePrefix,
            'title' => 'Data Tagihan',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $siswa = ModelsSiswa::all();
        $data = [
            'model' => new Model(),
            'method' => 'POST',
            'route' => $this->routePrefix.'.store',
            'button' => 'SIMPAN',
            'title' => 'Form Data Tagihan',
            'kelas' => $siswa->pluck('kelas','kelas'),
            'biaya' => Biaya::get(),
        ];
        return view('tu.' . $this->viewCreate, $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTagihanRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTagihanRequest $request)
    {
        //1. lakukan validasi
        //2. ambil data biaya yang ditagih
        //3. ambil data siswa yang ditagih berdasar kelas
        //4. lakukan perulangan untuk setiap siswa
        //5. didalam perulangan, simpan tagihan berdasarkan biaya & siswa
        //6. simpan notifikasi database untuk tagihan
        //7. redirect back() dengan pesan sukses
        $requestData = $request->validated();
        $biayaIdArray = $requestData['biaya_id'];
        $siswa = ModelsSiswa::query();
        if ($requestData['kelas'] != '') {
            $siswa->where('kelas', $requestData['kelas']);
        }
        $siswa = $siswa->get();
        foreach ($siswa as $item) {
            $itemSiswa = $item;
            $biaya = Biaya::whereIn('id', $biayaIdArray)->get();
            foreach ($biaya as $itemBiaya) {
                $dataTagihan = [
                    'siswa_id' => $itemSiswa->id,
                    'kelas' => $requestData['kelas'],
                    'tanggal_tagihan' => $requestData['tanggal_tagihan'],
                    'tanggal_jatuh_tempo' => $requestData['tanggal_jatuh_tempo'],
                    'nama_biaya' => $itemBiaya->nama,
                    'jumlah_biaya' => $itemBiaya->jumlah,
                    'keterangan' => $requestData['keterangan'],
                    'status' => 'baru',
                ];
                $tanggalJatuhTempo = Carbon::parse($requestData['tanggal_jatuh_tempo']);
                $tanggalTagihan = Carbon::parse($requestData['tanggal_tagihan']);
                $bulanTagihan = $tanggalTagihan->format('m');
                $tahunTagihan = $tanggalTagihan->format('Y');
                $cekTagihan = Model::where('siswa_id', $itemSiswa->id)
                    ->where('biaya_id', $itemBiaya->nama)
                    ->whereMonth('tanggal_tagihan', $bulanTagihan)
                    ->whereYear('tanggal_tagihan', $tahunTagihan)
                    ->first();
                if($cekTagihan == null) {
                    Model::create($dataTagihan);
                }
            }
        }
        flash('Tagihan berhasil disimpan')->success();
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tagihan  $tagihan
     * @return \Illuminate\Http\Response
     */
    public function show(Model $tagihan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tagihan  $tagihan
     * @return \Illuminate\Http\Response
     */
    public function edit(Model $tagihan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTagihanRequest  $request
     * @param  \App\Models\Tagihan  $tagihan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTagihanRequest $request, Model $tagihan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tagihan  $tagihan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Model $tagihan)
    {
        //
    }
}
