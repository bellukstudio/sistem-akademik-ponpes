<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use App\Models\MasterCategorieSchedule;
use App\Models\MasterPeriod;
use App\Models\MasterStudent;
use App\Models\TrxSchedule;

class JadwalController extends Controller
{
    /**
     * get schedules user by class
     */

    public function getScheduleByClass(Request $request)
    {
        try {
            $categorie = $request->input('category');
            $day = $request->input('day');
            //student
            $student = MasterStudent::where('email', $request->user()->email)->first();
            $period = MasterPeriod::where('status', 1)->first();

            $schedule =
                TrxSchedule::join('master_classes', 'trx_schedules.class_id', '=', 'master_classes.id')
                ->join('master_teachers', 'trx_schedules.teacher_id', '=', 'master_teachers.id')
                ->join('master_courses', 'trx_schedules.course_id', '=', 'master_courses.id')
                ->join('master_categorie_schedules', 'master_courses.category_id', '=', 'master_categorie_schedules.id')
                ->join('trx_class_groups', 'trx_class_groups.class_id', '=', 'master_classes.id')
                ->orderBy('trx_schedules.class_id')
                ->where('trx_class_groups.student_id', $student->id)
                ->where('trx_schedules.id_period', $period->id)
                ->select(
                    'master_teachers.name as teacher_name',
                    'master_courses.course_name as course_name',
                    'master_classes.class_name as class_name',
                    'master_classes.id as class_id',
                    'trx_schedules.day as day',
                    'trx_schedules.time as times',
                    'trx_schedules.id as id_schedules',
                    'master_categorie_schedules.categorie_name as categorie_name'
                );
            if ($categorie) {
                $schedule->where('master_categorie_schedules.categorie_name', $categorie);
            }
            if ($day) {
                $schedule->where('trx_schedules.day', $day);
            }

            $data = $schedule->orderByRaw("field(trx_schedules.day,'Ahad',
                'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu')")->get()->map(function ($item) {
                $item->class_id = (int) $item->class_id;
                $item->id_schedules = (int) $item->id_schedules;
                return $item;
            });
            return ApiResponse::success($data, 'Get schedules successfully');
        } catch (\Exception $e) {
            return ApiResponse::error([
                'message' => 'Something went wrong',
                'error' => $e
            ], 'Opps', 500);
        }
    }

    public function getCategorySchedule()
    {
        try {
            $category = MasterCategorieSchedule::all();
            return ApiResponse::success($category, 'Get category schedules success');
        } catch (\Exception  $e) {
            return ApiResponse::error([
                'message' => 'Something went wrong',
                'error' => $e
            ], 'Opps', 500);
        }
    }
}
