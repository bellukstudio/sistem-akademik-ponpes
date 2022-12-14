<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\Activation as MailActivation;
use App\Models\Activation as ModelActivation;
use App\Models\MasterStudent;
use App\Models\MasterTeacher;
use App\Models\MasterUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ActivationController extends Controller
{
    public function activation()
    {
        return view('authentication.activation.activation');
    }

    public function sendEmail(Request $request)
    {
        $request->validate([
            'role' => 'required',
            'email' => 'required|email:dns'
        ]);

        $tableStudent = 'master_students';
        $tableTeacher = 'master_teachers';

        //
        try {
            if ($request->role == 'santri') {
                $student = MasterStudent::where('email', $request->email)->count();
                if ($student == 0) {
                    return back()->withErrors([
                        'email' => 'Email is not registered',
                    ]);
                } else {
                    $users = MasterUsers::where('email', $request->email)->count();
                    if ($users == 0) {
                        $generateCode = Str::random(50);
                        // send email
                        Mail::to($request->email)->send(new MailActivation($request->email, $generateCode));
                        // save data
                        ModelActivation::create([
                            'table_name' => $tableStudent,
                            'email' => $request->email,
                            'activation_code' => $generateCode,
                        ]);
                        return back()->with([
                            'success' => 'Cek pesan email sekarang',
                        ]);
                    } else {
                        return back()->with('success', 'Akun anda sudah di aktivasi');
                    }
                }
            } elseif ($request->role == 'pengajar') {
                $teacher = MasterTeacher::where('email', $request->email)->count();
                if ($teacher == 0) {
                    return back()->withErrors([
                        'email' => 'Email is not registered',
                    ]);
                } else {
                    $users = MasterUsers::where('email', $request->email)->count();
                    if ($users == 0) {
                        $generateCode = Str::random(50);
                        // send email
                        Mail::to($request->email)->send(new MailActivation($request->email, $generateCode));
                        // save data
                        ModelActivation::create([
                            'table_name' => $tableTeacher,
                            'email' => $request->email,
                            'activation_code' => $generateCode,
                        ]);
                        return back()->with([
                            'success' => 'Cek pesan email sekarang',
                        ]);
                    } else {
                        return back()->with('success', 'Akun anda sudah di aktivasi');
                    }
                }
            }
        } catch (\Exception $e) {
            return back()->withErrors([
                'email' => 'Something error or Email is not registered',
            ]);
        }
    }

    public function redemCode()
    {
        $url = explode('/', url()->current());
        $token =  ModelActivation::where('activation_code', $url[4])->firstOrFail();
        $time = $token->created_at->format('d-m-Y H:i:s');

        $date = date_create($time);
        date_add($date, date_interval_create_from_date_string('10 minutes'));
        $result = date_format($date, 'd-m-Y H:i:s');

        // current date time
        $currentDate = date('d-m-Y H:i:s');
        $currentDate = date('d-m-Y H:i:s', strtotime($currentDate));

        if ($currentDate > $result) {
            // delete token
            $activationTable = ModelActivation::find($token->id);
            $activationTable->delete();
            return redirect()->route('login')->with('failed', 'Kode aktivasi sudah kadaluarsa');
        } else {
            //! get data from table
            $table =  DB::table($token->table_name)->where('email', $token->email)->get()->firstOrFail();
            //? get date birth and replace it
            $dateBirth = str_replace('-', '', $table->date_birth);
            //update is activate field
            DB::table($token->table_name)->where('id', $table->id)
                ->update(['is_activate' => true]);
            if ($token->table_name === 'master_students') {
                // insert data to table users
                MasterUsers::create([
                    'name' => $table->name,
                    'email' => $table->email,
                    'roles' => 4,
                    'password' => Hash::make($dateBirth)
                ]);
            } elseif ($token->table_name === 'master_teachers') {
                // insert data to table users
                MasterUsers::create([
                    'name' => $table->name,
                    'email' => $table->email,
                    'roles' => 2,
                    'password' => Hash::make($dateBirth)
                ]);
            }

            // delete token
            $activationTable = ModelActivation::find($token->id);
            $activationTable->delete();
            return redirect()->route('login')->with('success', 'Berhasil melakukan aktivasi');
        }
    }
}
