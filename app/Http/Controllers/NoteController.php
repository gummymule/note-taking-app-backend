<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Tag;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Note::with('tags')->where('archived', false)->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'tags' => 'array',
            'tags.*' => 'exists:tags,id',
        ]);

        $note = Note::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'last_edited' => now(),
        ]);

        if (isset($validated['tags'])) {
            $note->tags()->attach($validated['tags']);
        }

        return response()->json($note->load('tags'), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $note = Note::findOrFail($id);
        return $note->load('tags');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'title' => 'string|max:255',
            'content' => 'string',
            'archived' => 'boolean',
            'tags' => 'sometimes|array',
            'tags.*' => 'sometimes|integer|exists:tags,id',
        ]);

        $note = Note::findOrFail($id);

        $note->update(array_merge($validated, ['last_edited' => now()]));

        if (isset($validated['tags'])) {
            $note->tags()->sync($validated['tags']);
        }

        return $note->load('tags');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $note = Note::findOrFail($id);
        $note->delete();
        return response()->noContent();
    }

    public function addTags(Note $note, Request $request)
    {
        $validated = $request->validate([
            'tags' => 'required|array',
            'tags.*' => 'exists:tags,id',
        ]);

        $note->tags()->attach($validated['tags']);
        return $note->load('tags');
    }

    public function removeTag(Note $note, Tag $tag)
    {
        $note->tags()->detach($tag->id);
        return $note->load('tags');
    }

    public function getAllTags()
    {
        return Tag::all();
    }
}
