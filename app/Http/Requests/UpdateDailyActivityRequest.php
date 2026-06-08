<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDailyActivityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tanggal' => ['required', 'date'],
            'aktivitas' => ['required', 'string', 'min:5'],
            'status' => ['required', 'in:selesai,progress,kendala'],
            'keterangan' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'tanggal.required' => 'Tanggal wajib diisi.',
            'aktivitas.required' => 'Aktivitas wajib diisi.',
            'status.required' => 'Status wajib dipilih.',
            'status.in' => 'Status harus salah satu dari selesai, progress, atau kendala.',
        ];
    }
}
