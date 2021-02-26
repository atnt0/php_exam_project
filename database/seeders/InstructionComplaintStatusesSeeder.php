<?php

namespace Database\Seeders;

use App\Models\InstructionComplaintStatus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InstructionComplaintStatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arrayStatuses = [
            [
                //'id' => 1,
                'name' => 'pending',
                'title' => 'Pending',
            ],
            [
                'name' => 'processed',
                'title' => 'Processed',
            ],
            [
                'name' => 'confirmed',
                'title' => 'Confirmed',
            ],
            [
                'name' => 'rejected',
                'title' => 'Rejected',
            ],
            [
                'name' => 'accepted',
                'title' => 'Accepted',
            ],
        ];

        if( count($arrayStatuses) > 0 ){
            foreach ($arrayStatuses as $status) {
                $statusFound = DB::table('instruction_complaint_statuses')
                    ->where('name', '=', $status['name'])->first();

                if( !$statusFound ) {
                    $newStatus = new InstructionComplaintStatus();
                    //$newStatus->id = $status['id'];
                    $newStatus->name = $status['name'];
                    $newStatus->title = $status['title'];

                    $newStatus->save();
                }
            }
        }

    }
}
