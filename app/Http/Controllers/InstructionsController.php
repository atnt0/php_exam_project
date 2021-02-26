<?php

namespace App\Http\Controllers;

use App\Models\Instruction;
use App\Models\User;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Webpatser\Uuid\Uuid;

class InstructionsController extends Controller
{

    const INSTRUCTION_NEW_STATUS_APPROVED = 0; // 0 - статус подтверждения - ожидание утверждения администрацией проекта
    const INSTRUCTION_STATUS_APPROVED_YES = 1; // 1 - статус подтверждения - утверждено администрацией проекта


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $instructions = Instruction::all();

        if( User::hasRightsAdmin() ){
            // для администрации доступны ВСЕ и одобренные и не одобренные инструкции
            $instructions = Instruction::get();
        }
        else {
            // для пользователей доступны только инструкции одобренные администрацией
            $instructions = Instruction::where('status_approved', '!=', self::INSTRUCTION_NEW_STATUS_APPROVED)->get();
        }

        return view('instructions.index', compact('instructions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if ( Auth::guest() )
            return redirect('/login');

        return view('instructions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ( Auth::guest() )
            return redirect('/login');

        $request->validate([
            'title' => 'required|min:4',
            'description' => 'required',
            'file'=>'required|file|mimes:txt', // jpg,bmp,png,pdf,
        ]);


        $file = $request->file("file");

        $fileName = Uuid::generate()->string .'_.txt';

        $newFilePath = Storage::putFileAs('public', new File($file->getPathname()), $fileName);

        $userId = Auth::user() ? Auth::user()->id : -1;

        $instruction = new Instruction([
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'file_name' => $fileName,
            'status_approved' => self::INSTRUCTION_NEW_STATUS_APPROVED,
            'author_id' => $userId,
        ]);

        $instruction->save();

        return redirect()
            ->route('instructions.show', [$instruction->id])
            ->with('success', 'Instruction saved!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $instruction = Instruction::find($id);

        if( empty($instruction) )
            abort(404);

        // если не подтверждено, не юзер это не автор инструкции или не админ
        if( $instruction->status_approved == 0 && !self::hasRights($instruction->author_id) )
            abort(403);


        $fileLink = '/storage/'. basename($instruction->file_name); // для получения ссылки на публичный доступ

        $fileContent = Storage::get('public/'. $instruction->file_name); // для получения содержимого локально

        return view('instructions.show', compact('instruction', 'fileLink', 'fileContent'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = Auth::user();

        //if ( Auth::guest() )
        if( !Auth::user() )
            return redirect('/login');

        $instruction = Instruction::find($id);

        if( !self::hasRights($instruction->author_id) )
            abort(403);

        //if( Auth::user() && (Auth::user()->id == $instruction->author_id || Auth::user()->hasRole('admin') ) )
        return view('instructions.edit', compact('instruction'));
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
        $user = Auth::user();

        //if ( Auth::guest() )
        if( !Auth::user() )
            return redirect('/login');

        $instruction = Instruction::find($id);

        if( !self::hasRights($instruction->author_id) )
            abort(403);

//        if( $instruction->authorId == $user->id ) {
//        if( Auth::user() && (Auth::user()->id == $instruction->author_id || Auth::user()->hasRole('admin')) ) {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        $instruction->title = $request->get('title');
        $instruction->description = $request->get('description');
//        $instruction->status = $request->get('status_approved');

        $instruction->save();

        return redirect()
            ->route('instructions.show', [$instruction->id])
            ->with('success', 'Instruction updated!');
    }

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

        $instruction = Instruction::find($id);

        if( !self::hasRights($instruction->author_id) )
            abort(403);

        $instruction->delete();

        return redirect()
            ->route('instructions.index')
            ->with('success', 'Instruction deleted!');
    }



    /**
     * @return bool
     * Description: определить есть ли права изменения данной записи
     *  разместил здесь, так как в модель User слишком много требуется добавлять, что не есть хорошо
     */
    public static function hasRights($author_id): bool
    {
        return Auth::user() && (Auth::user()->id == $author_id || Auth::user()->hasRole('admin') ); // Admin
    }


    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * Description: ajax-поиск в инструкциях по названию
     */
    public function searchAjax(Request $request){
        $searchString = $request->get('searchString');

        if( User::hasRightsAdmin() ){
            // для администрации доступны и не одобренные инструкции
            $instructions = Instruction::where('title', 'like', '%'.$searchString.'%')
                //->where('status_approved', '!=', self::INSTRUCTION_NEW)
                ->get();
        }
        else {
            // для пользователей доступны только инструкции одобренные администрацией
            $instructions = Instruction::where('title', 'like', '%' . $searchString . '%')
                ->where('status_approved', '!=', self::INSTRUCTION_NEW_STATUS_APPROVED)
                ->get();
        }

        return view('instructions.parts._items', compact('instructions'));
    }

    // event for Approved this instruction
    public function setApproved(Request $request, $instructionId) //
    {
        if ( Auth::guest() )
            return redirect('/login');

        if( ! User::hasRightsAdmin() )
            abort(403); //TODO change to current address whit message


        $instruction = Instruction::find($instructionId);

        if( empty($instruction) )
            abort(404);

        if( !self::hasRights($instruction->author_id) )
            abort(403);

        $instruction->status_approved = self::INSTRUCTION_STATUS_APPROVED_YES;
        $instruction->approved_at = date("Y-m-d h:i:s", time());

        $instruction->save();

        return redirect()
            ->route('instructions.show', [$instructionId])
            ->with('success', 'Instruction Approved!');
    }



}
