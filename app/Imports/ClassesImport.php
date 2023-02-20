<?php

namespace App\Imports;

use App\Models\MasterAcademicProgram;
use App\Models\MasterClass;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Importable;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

class ClassesImport implements ToModel, WithValidation, WithHeadingRow
{
    use Importable;
    private $class;
    private $program;

    public function __construct()
    {
        $this->class = MasterClass::class;
        $this->program = MasterAcademicProgram::class;
        HeadingRowFormatter::default('none');
    }

    public function model(array $row)
    {
        // cari id program berdasarkan nama program yang diinputkan
        $program = $this->program::where('program_name', $row['Nama Program'])->first();
        $program_id = $program ? $program->id : null;

        return new MasterClass([
            'class_name' => $row['Nama Kelas'],
            'program_id' => $program_id
        ]);
    }

    public function rules(): array
    {
        $programIds = MasterAcademicProgram::pluck('id', 'program_name')->toArray();

        return [
            'Nama Kelas' => [
                'required',
                Rule::unique('master_classes', 'class_name')->ignore($this->class)
            ],
            'Nama Program' => [
                'required',
                Rule::in(array_keys($programIds))
            ]
        ];
    }

    public function customValidationMessages()
    {
        return [
            'Nama Kelas.required' => 'Nama kelas harus diisi',
            'Nama Kelas.unique' => 'Nama kelas sudah pernah disimpan',
            'Nama Program.required' => 'Program harus diisi',
            'Nama Program.in' => 'Program tidak terdaftar pada sistem'
        ];
    }
}
