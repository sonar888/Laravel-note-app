<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notes = Note::query() 
        ->where('user_id', request()->user()->id)
        -> orderBy("created_at","desc")
        -> paginate();
        
        return view('note.index', ['notes' => $notes]);
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        return view('note.create');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $data=$request -> validate([
            'note' => ['required', 'string'] // here note is the name of the field in the form
       ]);

       $data['user_id'] = request()->user()->id;

       $note = Note::create($data); // don't forget to add the fillabel in the note model note.php

       return to_route('note.show', $note)-> with('message', 'Note was created!'); // here message is a session message added to the view file with @session
    }

    /**
     * Display the specified resource.
     */
    public function show(Note $note)
    {
        if($note->user_id !== request()->user()->id){
            abort(403);
        }
        return view('note.show', ['note' => $note]);
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Note $note)
    {
        if($note->user_id !== request()->user()->id){
            abort(403);
        }
        return view('note.edit', ['note' => $note]);
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Note $note)
    {
        if($note->user_id !== request()->user()->id){
            abort(403);
        }
        $data=$request -> validate([
             'note' => ['required', 'string'] // here note is the name of the field in the form
        ]);
 
       
 
        $note ->update($data);
 
        return to_route('note.show', $note)-> with('message', 'Note was updated!'); // here message is a session message added to the view file with @session
     }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Note $note)
    {
        if($note->user_id !== request()->user()->id){
            abort(403);
        }
        $note->delete();
        return to_route('note.index')->with('message','Note was deleted!');
    }
}
