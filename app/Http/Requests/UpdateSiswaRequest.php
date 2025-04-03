<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSiswaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'siswa_id' => 'nullable',
            'nama' => 'required',
            'nisn' => 'required|unique:siswas,nisn,'. $this->siswa, 
            'jurusan' => 'required',
            'kelas' => 'required',
            'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:5000',
        ];
    }
}
