<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends FormRequest
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
            'nombre' => 'required|string|min:5|max:60',
            'email' => 'required|email',
            'password' => 'required|string|between:12,64|not_regex:/(\W+)/',
            'genero' => 'required|string|size:1',
            'identificacion' => 'required|numeric|digits_between:5,16',
            'apellido' => 'required|string|max:45',
            'direccion' => 'required|string|min:5|max:80',
            'telefono' => 'required|numeric|digits_between:5,16',
            'telefono_alterno' => 'numeric|digits_between:5,16',
            'fecha_nacimiento' => 'date',
            'rol_id' => 'required|numeric|integer'
        ];
    }
}
