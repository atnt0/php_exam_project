<?php

namespace App\Http\Controllers;

use App\Models\Instruction;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class InstructionsController extends Controller
{

    const INSTRUCTION_NEW = 1;


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //f( Auth::guest() )
        //    return redirect('/login');

        $instructions = Instruction::all();
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
            'file'=>'required|file|mimes:jpg,bmp,png,pdf,txt',
        ]);


        $file = $request->file("file");

        $fileName = Uuid::generate()->string .'_.txt';

        $newFilePath = Storage::putFileAs('public', new File($file->getPathname()), $fileName);

        $user = Auth::user();
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
        $fileContent = Storage::get($instruction->filename);

        return view('instructions.show', compact('instruction', 'fileContent'));
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

        if( $instruction->authorId == $user->id )
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

        if( $instruction->authorId == $user->id ) {
            $request->validate([
                'title' => 'required',
                'description' => 'required',
            ]);

            $instruction->name = $request->get('title');
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

        if( $instruction->authorId == $user->id ){
            $instruction->delete();
            return redirect('/instructions')->with('success', 'Instruction deleted!');
        }
        else
            return redirect('/instructions');
    }


    public function search(Request $request){
        $searchString = $request->get('searchString');

        $instructions = Instruction::where('name', 'like', '%'.$searchString.'%')->get();

        return view('instructions.index', compact('instructions'));
    }


}
