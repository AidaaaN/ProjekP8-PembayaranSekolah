@extends('layouts.app_sneat')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">{{ $title }}</h5>
                <div class="card-body">
                {!! Form::model($model, ['route' => $route, 'method' => $method, 'enctype' => 'multipart/form-data'], ) !!}
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        {!! Form::text('nama', null, ['class' => 'form-control', 'autofocus']) !!}
                        <span class="text-danger">{{ $errors->first('nama') }}</span>
                    </div>
                    <div class="form-group mt-3">
                        <label for="nisn">NISN</label>
                        {!! Form::text('nisn', null, ['class' => 'form-control']) !!}
                        <span class="text-danger">{{ $errors->first('nisn') }}</span>
                    </div>
                    <div class="form-group mt-3">
                        <label for="jurusan">Jurusan</label>
                        {!! Form::select('jurusan',
                            [
                            'PPLG'=> 'Pengembangan Perangkat Lunak & Gim',
                            'TKJ' => 'Teknik Komputer & Jaringan',
                            'DKV' => 'Desain Komunisasi Visual',
                            'TB' => 'Tata Busana',
                            'TP' => 'Teknik Permesinan',
                            'TKR' => 'Teknik Kendaraan Ringan',
                            'TPL' => 'Teknik Pengelasan Logam',
                            'AK' => 'Akuntansi',
                            ],
                              null, 
                              ['class' => 'form-control'],) !!}
                        <span class="text-danger">{{ $errors->first('jurusan') }}</span>
                    </div>
                    <div class="form-group mt-3">
                        <label for="kelas">Kelas</label>
                        {!! Form::selectRange('kelas',10,12,null, ['class' => 'form-control']) !!}
                        <span class="text-danger">{{ $errors->first('kelas') }}</span>
                    </div>
                    @if ($model->foto != null)
                            <div class="m-3">
                            <img src="{{ \Storage::url($model->foto) }}" alt="" width="200" class="img-thumbnail">
                            </div>
                    @endif
                    <div class="form-group mt-3">
                        <label for="foto"><b>(Format: jpg, jpgeg, png, Ukuran Maks: 5MB)</b></label>
                        {!! Form::file('foto', ['class' => 'form-control', 'accept' => 'image/*']) !!}
                        <span class="text-danger">{{ $errors->first('foto') }}</span>
                    </div>
                   
                    {!! Form::submit($button, ['class' => 'btn btn-primary mt-3']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
