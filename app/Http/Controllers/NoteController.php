<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Note;

class NoteController extends Controller
{

    public function index()
    {
        $notes = Note::orderBy('updated_at', 'desc')->get();
        return view('notes', ['notes' => $notes]);
    }

    public function showNotes($id)
    {
        $note = Note::find($id); 
        if (!$note) {
            return redirect()->route('index')->with('ERROR', 'NOTE NOT FOUND!');
        }

        return view('note', ['note' => $note]);
    }

    public function createNote()
    {
        return view('create-note');
    }

    public function createNotes(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'content' => 'required|string|max:10000',
        ]);

        $note = new Note();
        $note->title = $validated['title'];
        $note->description = $validated['description'];
        $note->content = $validated['content'];
        $note->save();

        return redirect()->route('index')->with('CONGRATSSS', 'YOU HAVE SUCCESFULLY CREATED A NEW NOTE');
    }

    public function editNotes($id)
    {
        $note = Note::find($id);

        if (!$note) {
            return redirect()->route('index')->with('ERROR', 'NOTE IS NOT HERE!');
        }

        return view('edit-note', ['note' => $note]);
    }

    public function updateNotes(Request $request, $id) 
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'content' => 'required|string|max:10000',
        ]);

        $note = Note::find($id);

        if (!$note) {
            return redirect()->route('index')->with('ERROR', 'NOTE NOT FOUND!');
        }

        $note->title = $validated['title'];
        $note->description = $validated['description'];
        $note->content = $validated['content'];
        $note->save();

        return redirect()->route('index', ['id' => $note->id])->with('SUCCESS', 'CHANGES HAS BEEN DONE.');
    }

    public function deleteNotes(Request $request, $id)
    {
       
        $note = Note::find($id);
        if ($note) {
            $note->delete();
        }

        return redirect()->route('index')->with('NOTE DELETED SUCCESFULLY');
    }

    public function search(Request $request)
    {
        
        $query = $request->input('query');

        $notes = Note::where('title', 'like', "%{$query}%")->orderBy('updated_at', 'desc')->get();

        return view('notes', ['notes' => $notes]);
    }

}

