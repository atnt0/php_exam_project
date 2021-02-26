<?php

namespace App\Http\Controllers;

use App\Models\Instruction;
use App\Models\InstructionComplaint;
use App\Models\InstructionComplaintStatus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InstructionСomplaintsController extends Controller
{
    const DEFAULT_INSTRUCTION_COMPLAINT_STATUS = 1;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ( Auth::guest() )
            return redirect('/login');

        if( ! User::hasRightsAdmin() )
            return redirect('/instructions');


        // видны ВСЕ жалобы, но только для админов
        $complaints = InstructionComplaint::getComplaints();

        return view('instructioncomplaints.index', compact('complaints' )); // 'role'
    }

//    /**
//     * Show the form for creating a new resource.
//     *
//     * @return \Illuminate\Http\Response
//     */
//    public function create()
//    {
//        return view('instructions.complaints.createForInstructionId', compact('instructionId'));
//    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     *  Description: event create For Instruction Id
     */
    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|min:10',
            'instruction_id' => 'required|integer',
        ]);

        //TODO добавить проверку на пользователя
        $userId = Auth::user()->id;

        $instructionComplaint = new InstructionComplaint([
            'user_id' => $userId,
            'instruction_id' => $request->get('instruction_id'),
            'instruction_complaint_status_id' => self::DEFAULT_INSTRUCTION_COMPLAINT_STATUS,
            'description' => $request->get('description'),
        ]);

        $instructionComplaint->save();

        $instructionId = $instructionComplaint->instruction_id;

        return redirect()
            ->route('instructions.complaints.show', [$instructionComplaint->id])
            ->with('success', 'Instruction Complaint saved!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($complaintId)
    {
        $complaint = InstructionComplaint::find($complaintId);
//            ->firstOrFail(); // возвращает первую запись вместо необходимой, воздержаться от использования

        if( empty($complaint) )
            abort(404);

        $instruction = Instruction::find($complaint->instruction_id);


        if( empty($instruction) )
            abort(404);

        return view('instructioncomplaints.show', compact('complaint', 'instruction'));
    }

//    /**
//     * Show the form for editing the specified resource.
//     *
//     * @param  int  $id
//     * @return \Illuminate\Http\Response
//     */
//    public function edit($id)
//    {
//        //
//    }

//    /**
//     * Update the specified resource in storage.
//     *
//     * @param  \Illuminate\Http\Request  $request
//     * @param  int  $id
//     * @return \Illuminate\Http\Response
//     */
//    public function update(Request $request, $id)
//    {
//        //
//    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if( !Auth::user() )
            return redirect('/login');

        $instructionComplaint = InstructionComplaint::find($id);

        if( empty($instructionComplaint) )
            abort(404);

        $instructionComplaint->delete();

        return redirect()
            ->route('instructions.complaints.index')
            ->with('success', 'Instruction deleted!');
    }




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createForInstructionId($instructionId)
    {
        $instruction = Instruction::find($instructionId);

        if( empty($instruction) )
            abort(404);

        if( empty($instruction) )
            return redirect('/instructions');

        return view('instructioncomplaints.createForInstructionId', compact('instruction'));
    }

    public function complaintsByInstructionId($instructionId)
    {
        if ( Auth::guest() )
            return redirect('/login');

        if( ! User::hasRightsAdmin() )
            return redirect('/instructions');

        $instruction = Instruction::find($instructionId);

        if( empty($instruction) )
            abort(404);

        if( empty($instruction) )
            return redirect('/instructions');

        // видны ВСЕ жалобы для одной инструкции, но только для админав
        $complaints = InstructionComplaint::getComplaintsForInstruction($instructionId);

        return view('instructioncomplaints.indexComplaintsForInstruction', compact('complaints', 'instruction'));
    }

    // событие - принять жалобу
    public function setAccepted($instructionComplaintId)
    {
        $complaint = InstructionComplaint::find($instructionComplaintId);

        if( empty($complaint) )
            abort(404);

        $statusAccepted = InstructionComplaintStatus::getStatusByName('accepted');

        if( empty($statusAccepted) )
            abort(404);

        $complaint->instruction_complaint_status_id = $statusAccepted->id;
        $complaint->save();

        return redirect()
            ->route('instructions.complaints.index')
            ->with('success', 'Instruction Complaint Accepted!');
    }

    // событие - отклонить жалобу
    public function setRejected($instructionComplaintId)
    {
        $complaint = InstructionComplaint::find($instructionComplaintId);

        if( empty($complaint) )
            abort(404);

        $statusRejected = InstructionComplaintStatus::getStatusByName('rejected');

        if( empty($statusRejected) )
            abort(404);

        $complaint->instruction_complaint_status_id = $statusRejected->id;
        $complaint->save();

        return redirect()
            ->route('instructions.complaints.index')
            ->with('success', 'Instruction Complaint Rejected!');
    }


}
