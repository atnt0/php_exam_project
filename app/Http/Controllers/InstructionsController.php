<?php

namespace App\Http\Controllers;

use App\Models\Instruction;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Webpatser\Uuid\Uuid;

class InstructionsController extends Controller
{

    const INSTRUCTION_NEW = 1; // статус ожидания утверждения администрацией проекта


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $instructions = Instruction::all();

        if( self::hasRightsAdmin() ){
            // для администрации доступны и не одобренные инструкции
            $instructions = Instruction::get();
        }
        else {
            // для пользователей доступны только инструкции одобренные администрацией
            $instructions = Instruction::where('status', '!=', self::INSTRUCTION_NEW)->get();
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
            'status' => self::INSTRUCTION_NEW,
            'author_id' => $userId,
        ]);

        $instruction->save();

        //TODO может быть ссылку заменить на роут?
        return redirect('/instructions')->with('success', 'Instruction saved!');
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

        //if( Auth::user() && (Auth::user()->id == $instruction->author_id || Auth::user()->hasRole('Admin') ) )
        if( self::hasRights($instruction) )
            return view('instructions.edit', compact('instruction'));
        else
            return redirect('/instructions');
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

//        if( $instruction->authorId == $user->id ) {
//        if( Auth::user() && (Auth::user()->id == $instruction->author_id || Auth::user()->hasRole('Admin')) ) {
        if( self::hasRights($instruction) ) {
            $request->validate([
                'title' => 'required',
                'description' => 'required',
            ]);

            $instruction->title = $request->get('title');
            $instruction->description = $request->get('description');
            $instruction->status = $request->get('status');

            $instruction->save();

            return redirect('/instructions')->with('success', 'Instruction updated!');
        }
        else
            return redirect('/instructions');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Auth::user();

        //if ( Auth::guest() )
        if( !Auth::user() )
            return redirect('/login');

        $instruction = Instruction::find($id);

//        if( $instruction->authorId == $user->id ){
        if( self::hasRights($instruction) ) {
            $instruction->delete();
            return redirect('/instructions')->with('success', 'Instruction deleted!');
        }
        else
            return redirect('/instructions');
    }



    /**
     * @return bool
     * Description: определить есть ли права изменения данной записи
     *  разместил здесь, так как в модель User слишком много требуется добавлять, что не есть хорошо
     */
    public static function hasRights($instruction): bool
    {
        return Auth::user() && (Auth::user()->id == $instruction->author_id || Auth::user()->hasRole('Admin') );
    }

    /**
     * @return bool
     * Description: для определения прав пользователя, отличается от hasRights
     */
    public static function hasRightsAdmin(): bool
    {
        return Auth::user() && Auth::user()->hasRole('Admin' );
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * Description: ajax-поиск в инструкциях по названию
     */
    public function searchAjax(Request $request){
        $searchString = $request->get('searchString');

        if( self::hasRightsAdmin() ){
            // для администрации доступны и не одобренные инструкции
            $instructions = Instruction::where('title', 'like', '%'.$searchString.'%')
                //->where('status', '!=', self::INSTRUCTION_NEW)
                ->get();
        }
        else {
            // для пользователей доступны только инструкции одобренные администрацией
            $instructions = Instruction::where('title', 'like', '%' . $searchString . '%')
                ->where('status', '!=', self::INSTRUCTION_NEW)
                ->get();
        }

        return view('instructions.parts._items', compact('instructions', ));
    }




}
