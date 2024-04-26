<?php

namespace App\Models\Course;

use App\Models\course\CourseIntake;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseGroup extends Model
{
    use HasFactory;
    public function total_application(){
        return $this->hasMany(JoinGroup::class,'group_id');
    }
    public function intake_data(){
        return $this->belongsTo(CourseIntake::class,'course_intake_id');
    }

    public static function get_group_attend_percent($group_id=NULL){
        if (!$group_id) {
            return false;
        }

        $present_count = [];
        $absent_count = [];
        $leave_count = [];

        $total = 0;

        $getTotalGroupAttendance = AttendenceConfirmation::where('course_group_id', $group_id)->get();

        if ($getTotalGroupAttendance->isNotEmpty()) {
            $total = $getTotalGroupAttendance->count();

            foreach ($getTotalGroupAttendance as $row) {
                if ($row->application_status == 1) {
                    $present_count[] = $row;
                } elseif ($row->application_status == 2) {
                    $absent_count[] = $row;
                } elseif ($row->application_status == 3) {
                    $leave_count[] = $row;
                }
            }
        }

        // Calculate percentages
        $present_percentage = ($total > 0) ? (count($present_count) / $total) * 100 : 0;
        $absent_percentage = ($total > 0) ? (count($absent_count) / $total) * 100 : 0;
        $leave_percentage = ($total > 0) ? (count($leave_count) / $total) * 100 : 0;

        return [
            'present_percentage' => $present_percentage,
            'absent_percentage' => $absent_percentage,
            'leave_percentage' => $leave_percentage,
        ];
    }
}
