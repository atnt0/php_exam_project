<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class InstructionComplaintStatus extends Model
{
    use HasFactory;



    public static function getStatusByName($name)
    {
        if( empty($name) )
            abort(500);


        $status = DB::table('instruction_complaint_statuses')
            ->where('name', '=', $name)->first();

        if( empty($status) )
            abort(500);

        return $status;
    }


}
