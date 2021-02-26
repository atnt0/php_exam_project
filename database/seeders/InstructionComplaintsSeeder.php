<?php

namespace Database\Seeders;

use App\Models\InstructionComplaint;
use App\Models\InstructionComplaintStatus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InstructionComplaintsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arrayComplaints = [
            [
                'user_id' => 2,
                'instruction_id' => 1,
                'instruction_complaint_status_id' => 1,
                'description' => 'Данная инструкция к холодильнику устарела! Где мне искать информацию про льдогенератор, которого в старой версии данной модели не было?',
            ],
            [
                'user_id' => 2,
                'instruction_id' => 1,
                'instruction_complaint_status_id' => 1,
                'description' => 'Мне так и не ответили про предыдущую жалобу, в чем проблема?',
            ],
        ];

        if( count($arrayComplaints) > 0 ) {
            foreach ($arrayComplaints as $complaint) {
                $complaintFound = DB::table('instruction_complaints')
                    ->where('description', '=', $complaint['description'])->first();

                if( !$complaintFound ) {
                    $newComplaintFound = new InstructionComplaint();
                    $newComplaintFound->user_id = $complaint['user_id'];
                    $newComplaintFound->instruction_id = $complaint['instruction_id'];
                    $newComplaintFound->instruction_complaint_status_id = $complaint['instruction_complaint_status_id'];
                    $newComplaintFound->description = $complaint['description'];

                    $newComplaintFound->save();
                }
            }
        }
    }
}
