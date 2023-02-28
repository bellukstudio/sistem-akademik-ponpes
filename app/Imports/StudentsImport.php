<?php

namespace App\Imports;

use App\Models\MasterAcademicProgram;
use App\Models\MasterCity;
use App\Models\MasterPeriod;
use App\Models\MasterProvince;
use App\Models\MasterStudent;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Importable;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

class StudentsImport implements ToModel, WithValidation, WithHeadingRow
{
    use Importable;
    private $student;
    private $program;
    private $province;
    private $city;

    public function __construct()
    {
        $this->student = MasterStudent::class;
        $this->program = MasterAcademicProgram::class;
        $this->province = MasterProvince::class;
        $this->city = MasterCity::class;

        HeadingRowFormatter::default('none');
    }
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // cari id program berdasarkan nama program yang diinputkan
        $program = $this->program::where('program_name', $row['Nama Program'])->first();
        $program_id = $program ? $program->id : null;


        // cari id provinsi
        $province = $this->province::where('province_name', $row['Provinsi'])->first();
        $province_id = $province ? $province->id : null;

        // cari id kota
        $city = $this->city::where('city_name', $row['Kota'])->where('id_province', $province_id)->first();
        $city_id = $city ? $city->id : null;

        // simpan data ke database
        return new MasterStudent([
            'noId' => $row['Nomor Identitas'],
            'email' => $row['Email'],
            'name' => $row['Nama Lengkap'],
            'gender' => $row['Jenis Kelamin'],
            'address' => $row['Alamat'],
            'province_id' => $province_id,
            'city_id' => $city_id,
            'date_birth' => $row['Tanggal Lahir'],
            'father_name' => $row['Nama Ayah'],
            'mother_name' => $row['Nama Ibu'],
            'date_birth_father' => $row['Tanggal Lahir Ayah'],
            'date_birth_mother' => $row['Tanggal Lahir Ibu'],
            'phone' => $row['Nomor Telepon'],
            'parent_phone' => $row['Nomor Telepon Orang Tua'],
            'program_id' => $program_id,
            'entry_year' => $row['Tahun Masuk'],
        ]);
    }
    /**
     * @return array
     */

    public function rules(): array
    {
        $programIds = MasterAcademicProgram::pluck('id', 'program_name')->toArray();
        $provinceIds = MasterProvince::pluck('id', 'province_name')->toArray();
        $cityIds = MasterCity::pluck('id', 'city_name')->toArray();

        return [
            'Nomor Identitas' => [
                'required',
                'integer',
                Rule::unique('master_students', 'noId')->ignore($this->student),
            ],
            'Email' => [
                'required',
                'email:dns',
                Rule::unique('master_students', 'email')->ignore($this->student),
            ],
            'Nama Lengkap' => 'required|string|max:255',
            'Jenis Kelamin' => [
                'required',
                'max:15',
                Rule::in(['Laki-Laki', 'Perempuan']),
            ],
            'Alamat' => 'required|string',
            'Provinsi' => [
                'required',
                Rule::in(array_keys($provinceIds))
            ],
            'Kota' => [
                'required',
                Rule::in(array_keys($cityIds))
            ],
            'Tanggal Lahir' => 'required|date',
            'Tanggal Lahir Ayah' => 'required|date',
            'Tanggal Lahir Ibu' => 'required|date',
            'Nama Ayah' => 'required|string|max:100',
            'Nama Ibu' => 'required|string|max:100',
            'Nomor Telepon' => 'required|integer',
            'Nomor Telepon Orang Tua' => 'required|integer',
            'Nama Program' => [
                'required',
                'string',
                Rule::in(array_keys($programIds))
            ],
            'Tahun Masuk' => [
                'required',
                'string',
            ],
        ];
    }

    /**
     * @return array
     */
    public function customValidationMessages()
    {
        return [
            'Nomor Identitas.required' => 'No. ID harus diisi',
            'Nomor Identitas.integer' => 'No. ID harus berupa angka',
            // 'Nomor Identitas.max' => 'No. ID maksimal 50 karakter',
            'Nomor Identitas.unique' => 'No. ID sudah terdaftar',

            'email.required' => 'Email harus diisi',
            'email.email' => 'Email tidak valid',
            'email.unique' => 'Email sudah terdaftar',

            'Nama Lengkap.required' => 'Nama harus diisi',
            'Nama Lengkap.string' => 'Nama harus berupa teks',
            'Nama Lengkap.max' => 'Nama maksimal 255 karakter',

            'Jenis Kelamin.required' => 'Jenis kelamin harus diisi',
            'Jenis Kelamin.max' => 'Jenis kelamin maksimal 15 karakter',
            'Jenis Kelamin.in' => 'Jenis kelamin tidak valid',

            'Alamat.required' => 'Alamat harus diisi',
            'Alamat.string' => 'Alamat harus berupa teks',
            'Alamat.max' => 'Alamat maksimal 255 karakter',

            'Provinsi.required' => 'Provinsi harus diisi',
            'Provinsi.in' => 'Provinsi tidak terdaftar pada sistem',

            'Kota.required' => 'Kota harus diisi',
            'Kota.in' => 'Kota tidak terdaftar pada sistem',

            'Tanggal Lahir.required' => 'Tanggal lahir harus diisi',
            'Tanggal Lahir.date' => 'Tanggal lahir tidak valid',

            'Tanggal Lahir Ayah.required' => 'Tanggal lahir Ayah harus diisi',
            'Tanggal Lahir Ayah.date' => 'Tanggal lahir Ayah tidak valid',

            'Tanggal Lahir.required' => 'Tanggal lahir Ibu harus diisi',
            'Tanggal Lahir.date' => 'Tanggal lahir Ibu tidak valid',

            'Nama Ayah.required' => 'Nama Ayah harus diisi',
            'Nama Ayah.string' => 'Nama Ayah harus berupa teks',
            'Nama Ayah.max' => 'Nama Ayah maksimal 255 karakter',

            'Nama Ibu.required' => 'Nama Ibu harus diisi',
            'Nama Ibu.string' => 'Nama Ibu harus berupa teks',
            'Nama Ibu.max' => 'Nama Ibu maksimal 255 karakter',

            'Nomor Telepon.required' => 'No. Telepon harus diisi',
            'Nomor Telepon.integer' => 'No. Telepon harus berupa angka',

            'Nomor Telepon Orang Tua.required' => 'No. Telepon Orang Tua harus diisi',
            'Nomor Telepon Orang Tua.integer' => 'No. Telepon Orang Tua harus berupa angka',

            'Nama Program.required' => 'Nama Program harus diisi',
            'Nama Program.in' => 'Nama Program tidak terdaftar pada sistem',

            'Tahun Masuk.required' => 'Tahun Masuk harus diisi',
            'Tahun Masuk.string' => 'Tahun Masuk harus berupa teks',

        ];
    }
}
