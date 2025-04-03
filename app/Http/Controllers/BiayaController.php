<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBiayaRequest;
use App\Http\Requests\StoreSiswaRequest;
use App\Http\Requests\UpdateBiayaRequest;
use App\Http\Requests\UpdateSiswaRequest;
use Illuminate\Http\Request;
use App\Models\Biaya as Model;
use App\Models\User;
use Storage;

class BiayaController extends Controller
{
    private $viewIndex = 'biaya_index';
    private $viewCreate = 'biaya_form';
    private $viewEdit = 'biaya_form';
    private $viewShow = 'biaya_show';
    private $routePrefix = 'biaya';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if($request->filled('q')) {
            $models = Model::with('user')->search($request->q)->paginate(50);
        }else{
            $models = Model::with('user')->latest()->paginate(50);
        }
 
        return view('tu.'.$this->viewIndex, [
            'models' => $models,
            'routePrefix' => $this->routePrefix,
            'title' => 'Data Biaya',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'model' => new Model(),
            'method' => 'POST',
            'route' => $this->routePrefix.'.store',
            'button' => 'SIMPAN',
            'title' => 'Form Data Biaya',
            
        ];
        return view('tu.' . $this->viewCreate, $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Responsestore bia
     */
    public function store(StoreBiayaRequest $request)
    {
        Model::create($request->validated());
        flash('Data berhasil disimpan');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = Model::findOrFail($id);
        return view('tu.' . $this->viewShow, [
            'model' => $model,
            'title' => 'Detail Siswa'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = [
            'model' => Model::findOrFail($id),
            'method' => 'PUT',
            'route' => [$this->routePrefix.'.update', $id],
            'button' => 'UPDATE',
            'title' => 'Form Data Biaya',
            
        ];
        return view('tu.'.$this->viewEdit, $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */ 
    public function update(UpdateBiayaRequest $request, $id)
    {
        $model = Model::findOrFail($id);
        $model->fill($request->validated());
        $model->save();
        flash('Data berhasil diubah');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = Model::firstOrFail();
        $model->delete();
        flash('Data berhasil dihapus');
        return back();
    }
}
