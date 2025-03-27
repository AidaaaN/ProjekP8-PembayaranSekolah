<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa as Model;
use App\Models\User;
use Storage;

class SiswaController extends Controller
{
    private $viewIndex = 'siswa_index';
    private $viewCreate = 'siswa_form';
    private $viewEdit = 'siswa_form';
    private $viewShow = 'siswa_show';
    private $routePrefix = 'siswa';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        if($request->filled('q')) {
            $models = Model::search($request->q)->paginate(50);
        }else{
            $model = Model::latest()->paginate(50);
        }

        return view('tu.'.$this->viewIndex, [
            'models' => $models,
            'routePrefix' => $this->routePrefix,
            'title' => 'Data Siswa',
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
            'title' => 'Form Siswa',
            'siswa' => User::where('akses','siswa')->pluck('name','id')
        ];
        return view('tu.' . $this->viewCreate, $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $requestData = $request->validate([
            'siswa_id' => 'nullable',
            'nama' => 'required',
            'nisn' => 'required|unique:siswas',
            'jurusan' => 'required',
            'kelas' => 'required',
            'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:5000',

        ]);

        if ($request->hasFile('foto')) {
            $requestData['foto'] = $request->file('foto')->store('public');
        }
        

        $requestData['user_id'] = auth()->user()->id;
        Model::create($requestData);
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
            'title' => 'Form Data Siswa',
            
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
    public function update(Request $request, $id)
    {
        $requestData = $request->validate([
            'siswa_id' => 'nullable',
            'nama' => 'required',
            'nisn' => 'required|unique:siswas,nisn,'. $id, 
            'jurusan' => 'required',
            'kelas' => 'required',
            'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:5000',

            
        ]);
        $model = Model::findOrFail($id);
        Storage::delete($model->foto);
        if ($request->hasFile('foto')) {
            $requestData['foto'] = $request->file('foto')->store('public');
        }
        

        $requestData['user_id'] = auth()->user()->id;
        $model->fill($requestData);
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
