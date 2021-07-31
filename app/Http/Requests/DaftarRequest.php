<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DaftarRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'nohp' => 'required|numeric|min:10',
            'role_id' => 'required',
            'nama' => 'required',
            'email' => 'required|email',
            'username' => 'required',
            'password' => 'required',
            'jenis_kelamin' => 'required',
            'nama_rekening' => 'required',
            'no_rekening' => 'required',
            'alamat' => 'required',
            'ktp' => 'required|image|mimes:jpg,png,jpeg',
        ];
    }

    public function messages(){
        return [
            'nohp.required' => 'Nomor Hp tidak boleh kosong',
            'role_id.required' => 'Posisi tidak boleh kosong',
            'nama.required' => 'Nama tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Email tidak valid',
            'username.required' => 'Username tidak boleh kosong',
            'password.required' => 'Password tidak boleh kosong',
            'jenis_kelamin.required' => 'Jenis kelamin tidak boleh kosong',
            'nama_rekening.required' => 'Nama rekening tidak boleh kosong',
            'no_rekening.required' => 'Nomor rekening tidak boleh kosong',
            'alamat.required' => 'Alamat tidak boleh kosong',
            'nohp.min' => 'Nomor Hp tidak valid',
            'nohp.numeric' => 'NO HP yang di input hanya boleh angka',
            'ktp.required' => 'KTP tidak boleh kosong',
            'ktp.mimes' => 'KTP hanya di perbolehkan dalam bentuk JPG, PNG, JPEG',
            'ktp.image' => 'KTP hanya di perbolehkan dalam bentuk JPG, PNG, JPEG',
        ];
    }
}
