<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class InstructionComplaint extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'instruction_id',
        'description',
        'instruction_complaint_status_id'
    ];

    // возвращает ВСЕ жалобы, но только для админов
    public static function getComplaints(){

        // видны ВСЕ жалобы, но только для админов
        $complaints = DB::table('instruction_complaints as ic')
            ->join('users as u', 'ic.user_id', '=', 'u.id')
            ->join('instruction_complaint_statuses as ics', 'ic.instruction_complaint_status_id', '=', 'ics.id')
            ->join('instructions as i', 'ic.instruction_id', '=', 'i.id')

            ->select(
                'ic.id as id',
                'ic.instruction_id as instruction_id',
                'ic.description as description',
                'ics.title as title',
                'u.name as name',
                'i.id as instruction_id',
                'i.title as instruction_title',
                'ic.created_at as created_at',
                'ic.updated_at as updated_at',
            )
            ->get();

        return $complaints;
    }

    // возвращает ВСЕ жалобы для одной инструкции, но только для админав
    public static function getComplaintsForInstruction($instructionId){

        $complaints = DB::table('instruction_complaints as ic')
            ->join('users as u', 'ic.user_id', '=', 'u.id')
            ->join('instruction_complaint_statuses as ics', 'ic.instruction_complaint_status_id', '=', 'ics.id')
            ->join('instructions as i', 'ic.instruction_id', '=', 'i.id')

            ->where('ic.instruction_id', '=', $instructionId)
            //->where('ics.name', '=', 'processed') // только одобренные // pending
            ->select(
                'ic.id as id',
                'ic.instruction_id as instruction_id',
                'ic.description as description',
                'ics.title as title',
                'u.name as name',
                'i.id as instruction_id',
                'i.title as instruction_title',
                'ic.created_at as created_at',
                'ic.updated_at as updated_at',
            )
            ->get();

        return $complaints;
    }

}
