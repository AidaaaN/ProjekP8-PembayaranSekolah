<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTagihanRequest extends FormRequest
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
            'biaya_id.*' => 'required',
            'kelas' => 'nullable|numeric',
            'tanggal_tagihan' => 'required|date',
            'tanggal_jatuh_tempo' => 'required|date',
            'keterangan' => 'nullable|string',
        ];
    }
}
