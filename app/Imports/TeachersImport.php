<?php

namespace App\Imports;

use App\Models\MasterCity;
use App\Models\MasterProvince;
use App\Models\MasterTeacher;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;


class TeachersImport implements ToModel, WithValidation, WithHeadingRow
{
    use Importable;
    private $teachers;
    private $province;
    private $city;

    public function __construct()
    {
        $this->teachers = MasterTeacher::class;
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
        // cari id provinsi
        $province = $this->province::where('province_name', $row['Provinsi'])->first();
        $province_id = $province ? $province->id : null;

        // cari id kota
        $city = $this->city::where('city_name', $row['Kota'])->where('id_province', $province_id)->first();
        $city_id = $city ? $city->id : null;

        return new MasterTeacher([
            'noId' => $row['Nomor Identitas'],
            'email' => $row['Email'],
            'name' => $row['Nama Lengkap'],
            'gender' => $row['Jenis Kelamin'],
            'address' => $row['Alamat'],
            'date_birth' => $row['Tanggal Lahir'],
            'no_tlp' => $row['Nomor Telepon'],
            'province_id' => $province_id,
            'city_id' => $city_id
        ]);
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        $provinceIds = MasterProvince::pluck('id', 'province_name')->toArray();
        $cityIds = MasterCity::pluck('id', 'city_name')->toArray();

        return [
            'Nomor Identitas' => [
                'required',
                'integer',
                Rule::unique('master_teachers', 'noId')->ignore($this->teachers),
            ],
            'Email' => [
                'required',
                'email:dns',
                Rule::unique('master_teachers', 'email')->ignore($this->teachers),
            ],
            'Nama Lengkap' => 'required|string|max:255',
            'Jenis Kelamin' => [
                'required',
                'max:15',
                Rule::in(['Laki-Laki', 'Perempuan']),
            ],
            'Alamat' => 'required|string|max:255',
            'Tanggal Lahir' => 'required|date',
            'Nomor Telepon' => 'required|integer',
            'Provinsi' => [
                'required',
                Rule::in(array_keys($provinceIds))
            ],
            'Kota' => [
                'required',
                Rule::in(array_keys($cityIds))
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

            'Tanggal Lahir.required' => 'Tanggal lahir harus diisi',
            'Tanggal Lahir.date' => 'Tanggal lahir tidak valid',

            'Nomor Telepon.required' => 'No. Telepon harus diisi',
            'Nomor Telepon.integer' => 'No. Telepon harus berupa angka',
            // 'phone.max' => 'No. Telepon maksimal 20 karakter',

            'Provinsi.required' => 'Provinsi harus diisi',
            'Provinsi.in' => 'Provinsi tidak terdaftar pada sistem',

            'Kota.required' => 'Kota harus diisi',
            'Kota.in' => 'Kota tidak terdaftar pada sistem',
        ];
    }
}
