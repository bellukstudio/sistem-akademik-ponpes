<?php

namespace App\Imports;

use App\Models\MasterRoom;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

class FirstSheetRoom implements ToModel, WithHeadingRow, WithValidation
{
    use Importable;

    private $room;

    public function __construct()
    {
        $this->room = MasterRoom::class;
        HeadingRowFormatter::default('none');
    }

    public function model(array $row)
    {
        return new MasterRoom([
            'room_name' => $row['Nama Ruangan'],
            'capasity' => $row['Kapasitas'],
            'type' => $row['Tipe']
        ]);
    }
    public function rules(): array
    {
        return [
            'Nama Ruangan' => [
                'required',
                Rule::unique('master_rooms', 'room_name')->ignore($this->room)
            ],
            'Kapasitas' => [
                'required',
                'integer'
            ],
            'Tipe' => [
                'required',
                'string',
                Rule::in(['RUANGAN', 'KAMAR'])
            ]
        ];
    }
    public function customValidationMessages()
    {
        return [
            'Nama Ruangan.required' => 'Nama ruang tidak boleh kosong',
            'Nama Ruangan.unique' => 'Nama ruang sudah pernah disimpan',
            'Kapasitas.required' => 'Kapasitas ruang tidak boleh kosong',
            'Kapasitas.integer' => 'Kapasitas berupa angka',
            'Tipe.required' => 'Tipe ruang tidak boleh kosong',
            'Tipe.in' => 'Tipe tidak valid'
        ];
    }
}
