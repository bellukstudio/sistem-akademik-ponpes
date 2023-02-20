<?php

namespace App\Imports;

use App\Models\MasterAcademicProgram;
use App\Models\MasterCategorieSchedule;
use App\Models\MasterCourse;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

class CourseImport implements ToModel, WithValidation, WithHeadingRow
{
    use Importable;

    private $course;
    private $program;
    private $category;

    public function __construct()
    {
        $this->course = MasterCourse::class;
        $this->program = MasterAcademicProgram::class;
        $this->category = MasterCategorieSchedule::class;
        HeadingRowFormatter::default('none');
    }

    public function model(array $row)
    {
        // cari id program berdasarkan nama program yang diinputkan
        $program = $this->program::where('program_name', $row['Nama Program'])->first();
        $program_id = $program ? $program->id : null;

        $category = $this->category::where('categorie_name', $row['Kategori Mapel'])->first();
        $category_id = $category ? $category->id : null;

        return new MasterCourse([
            'course_name' => $row['Mata Pelajaran'],
            'program_id' => $program_id,
            'category_id' => $category_id
        ]);
    }

    public function rules(): array
    {
        $programIds = MasterAcademicProgram::pluck('id', 'program_name')->toArray();
        $categoryIds = MasterCategorieSchedule::pluck('id', 'categorie_name')->toArray();
        return [
            'Mata Pelajaran' => [
                'required',
                Rule::unique('master_courses', 'course_name')->ignore($this->course)
            ],
            'Nama Program' => [
                'required',
                Rule::in(array_keys($programIds))
            ],
            'Kategori Mapel' => [
                'required',
                Rule::in(array_keys($categoryIds))
            ]
        ];
    }

    public function customValidationMessages()
    {
        return [
            'Mata Pelajaran.required' => 'Nama Mapel tidak boleh kosong',
            'Mata Pelajaran.unique' => 'Nama mapel sudah pernah disimpan',
            'Nama Program.required' => 'ID Program tidak boleh kosong',
            'Nama Program.in' => 'ID Program tidak terdaftar pada sistem',
            'Kategori Mapel.required' => 'Kategori mapel tidak boleh kosong',
            'Kategori Mapel.in' => 'Kategori mapel tidak terdaftar pada sistem'
        ];
    }
}
