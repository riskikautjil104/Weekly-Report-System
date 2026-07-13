<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOvertimeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tanggal' => ['required', 'date', 'before_or_equal:today'],
            'jam_mulai' => ['required', 'date_format:H:i'],
            'jam_selesai' => ['required', 'date_format:H:i', 'after:jam_mulai'],
            'alasan' => ['required', 'string', 'min:10'],
            'image_hash' => ['required', 'string', 'size:64', 'regex:/^[a-f0-9]+$/'],
            'image_width' => ['required', 'integer', 'min:1'],
            'image_height' => ['required', 'integer', 'min:1'],
            'file_size_bytes' => ['required', 'integer', 'min:1'],
            'camera_facing' => ['nullable', 'string', 'in:environment,user,unknown'],
            'geo_latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'geo_longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'geo_accuracy' => ['nullable', 'numeric', 'min:0'],
            'device_user_agent' => ['required', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'tanggal.required' => 'Tanggal lembur wajib diisi.',
            'tanggal.before_or_equal' => 'Tanggal lembur tidak boleh di masa depan.',
            'jam_mulai.required' => 'Jam mulai wajib diisi.',
            'jam_selesai.required' => 'Jam selesai wajib diisi.',
            'jam_selesai.after' => 'Jam selesai harus setelah jam mulai.',
            'alasan.required' => 'Alasan lembur wajib diisi.',
            'alasan.min' => 'Alasan lembur minimal 10 karakter.',
            'image_hash.required' => 'Foto bukti wajib diambil dari kamera sebelum submit.',
            'image_hash.size' => 'Metadata foto bukti tidak valid.',
            'image_hash.regex' => 'Metadata foto bukti tidak valid.',
            'image_width.required' => 'Metadata foto bukti tidak lengkap.',
            'image_height.required' => 'Metadata foto bukti tidak lengkap.',
            'file_size_bytes.required' => 'Metadata foto bukti tidak lengkap.',
            'device_user_agent.required' => 'Metadata perangkat tidak tersedia.',
        ];
    }
}
