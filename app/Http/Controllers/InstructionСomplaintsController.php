<?php

namespace App\Http\Controllers;

use App\Models\Instruction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InstructionСomplaintsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ( Auth::guest() )
            return redirect('/login');

        if( !InstructionsController::hasRightsAdmin() )
            return redirect('/instructions');


        $complaints = DB::table('instruction_complaints as ic')
            ->join('users as u', 'ic.user_id', '=', 'u.id')
            ->join('instruction_complaint_statuses as ics', 'ic.instruction_complaint_status_id', '=', 'ics.id')
            ->select(
                'ic.id as id',
                'ic.instruction_id as instruction_id',
                'ic.description as description',
                'ics.title as title',
                'u.name as name',
                'ic.created_at as created_at',
                'ic.updated_at as updated_at',
            )
            ->get();

//        dd($complaints);

        return view('instructioncomplaints.index', compact('complaints' )); // 'role'
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }





    public function complaintsByInstructionId($instructionId)
    {
        if ( Auth::guest() )
            return redirect('/login');


        $complaints = DB::table('instruction_complaints as ic')
            ->join('users as u', 'ic.user_id', '=', 'u.id')
            ->join('instruction_complaint_statuses as ics', 'ic.instruction_complaint_status_id', '=', 'ics.id')

            ->where('ic.instruction_id', '=', $instructionId)
            ->where('ics.name', '=', 'processed') // только одобренные // pending
            ->select(
                'ic.id as id',
                'ic.instruction_id as instruction_id',
                'ic.description as description',
                'ics.title as title',
                'u.name as name',
                'ic.created_at as created_at',
                'ic.updated_at as updated_at',
            )
            ->get();

        //dd($complaints);

        $instruction = Instruction::find($instructionId)->firstOrFail()->title;
        //dd($instruction);
        return view('instructioncomplaints.indexComplaintsForInstruction', compact('complaints', 'instruction'));
    }




}
