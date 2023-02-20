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
    private $period;
    private $province;
    private $city;

    public function __construct()
    {
        $this->student = MasterStudent::class;
        $this->program = MasterAcademicProgram::class;
        $this->period = MasterPeriod::class;
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

        // cari id tahun ajar berdasarkan nama tahun ajar yang diinputkan
        $period = $this->period::where('code', $row['Tahun Ajar'])->first();
        $period_id = $period ? $period->id : null;

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
            'student_parent' => $row['Nama Orang Tua'],
            'no_tlp' => $row['Nomor Telepon'],
            'program_id' => $program_id,
            'period_id' => $period_id,
        ]);
    }
    /**
     * @return array
     */

    public function rules(): array
    {
        $programIds = MasterAcademicProgram::pluck('id', 'program_name')->toArray();
        $periodIds = MasterPeriod::pluck('id', 'code')->toArray();
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
            'Nama Orang Tua' => 'required|string|max:100',
            'Nomor Telepon' => 'required|integer',
            'Nama Program' => [
                'required',
                'string',
                Rule::in(array_keys($programIds))
            ],
            'Tahun Ajar' => [
                'required',
                'string',
                Rule::in(array_keys($periodIds))
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

            'Nama Orang Tua.required' => 'Orang tua / Wali harus diisi',
            'Nama Orang Tua.string' => 'Orang tua / Wali harus berupa teks',
            'Nama Orang Tua.max' => 'Orang tua / Wali maksimal 255 karakter',

            'Nomor Telepon.required' => 'No. Telepon harus diisi',
            'Nomor Telepon.integer' => 'No. Telepon harus berupa angka',
            // 'Nomor Telepon.max' => 'No. Telepon maksimal 20 karakter',

            'Nama Program.required' => 'Nama Program harus diisi',
            'Nama Program.in' => 'Nama Program tidak terdaftar pada sistem',

            'Tahun Ajar.required' => 'Tahun Ajar harus diisi',
            'Tahun Ajar.in' => 'Tahun Ajar tidak terdaftar pada sistem',
        ];
    }
}
