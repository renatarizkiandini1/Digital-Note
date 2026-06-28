<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class NoteController extends Controller
{
    public function index(Request $request)
    {
        $query = Note::where('user_id', Auth::id());

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('content', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->category) {
            $query->where('category', $request->category);
        }

        if ($request->filter === 'pinned') {
            $query->where('is_pinned', true);
        } elseif ($request->filter === 'favorite') {
            $query->where('is_favorite', true);
        }

        $sort = $request->sort ?? 'latest';
        if ($sort === 'oldest') {
            $query->oldest();
        } elseif ($sort === 'title') {
            $query->orderBy('title');
        } else {
            $query->latest();
        }

        $notes = $query->paginate(9)->withQueryString();
        $categories = Note::where('user_id', Auth::id())->distinct()->pluck('category')->filter();

        return view('notes.index', compact('notes', 'categories'));
    }

    public function dashboard()
    {
        $userId = Auth::id();
        $total = Note::where('user_id', $userId)->count();
        $pinned = Note::where('user_id', $userId)->where('is_pinned', true)->count();
        $favorites = Note::where('user_id', $userId)->where('is_favorite', true)->count();
        $categories = Note::where('user_id', $userId)->distinct()->pluck('category')->filter()->count();
        $recent = Note::where('user_id', $userId)->latest()->take(5)->get();
        $trash = Note::where('user_id', $userId)->onlyTrashed()->count();

        return view('notes.dashboard', compact('total', 'pinned', 'favorites', 'categories', 'recent', 'trash'));
    }

    public function create()
    {
        $categories = Note::where('user_id', Auth::id())->distinct()->pluck('category')->filter();
        return view('notes.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'    => 'required|max:255',
            'content'  => 'required',
            'category' => 'nullable|max:100',
            'image'    => 'nullable|image|max:2048',
        ]);

        $validated['user_id']    = Auth::id();
        $validated['is_pinned']  = $request->boolean('is_pinned');
        $validated['is_favorite'] = $request->boolean('is_favorite');

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('notes', 'public');
        }

        Note::create($validated);
        return redirect()->route('notes.index')->with('success', 'Catatan berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $note = Note::where('user_id', Auth::id())->findOrFail($id);
        $categories = Note::where('user_id', Auth::id())->distinct()->pluck('category')->filter();
        return view('notes.edit', compact('note', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $note = Note::where('user_id', Auth::id())->findOrFail($id);

        $validated = $request->validate([
            'title'    => 'required|max:255',
            'content'  => 'required',
            'category' => 'nullable|max:100',
            'image'    => 'nullable|image|max:2048',
        ]);

        $validated['is_pinned']  = $request->boolean('is_pinned');
        $validated['is_favorite'] = $request->boolean('is_favorite');

        if ($request->hasFile('image')) {
            if ($note->image) Storage::disk('public')->delete($note->image);
            $validated['image'] = $request->file('image')->store('notes', 'public');
        }

        $note->update($validated);
        return redirect()->route('notes.index')->with('success', 'Catatan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $note = Note::where('user_id', Auth::id())->findOrFail($id);
        $note->delete();
        return redirect()->back()->with('success', 'Catatan dipindahkan ke tempat sampah!');
    }

    public function trash()
    {
        $notes = Note::where('user_id', Auth::id())->onlyTrashed()->latest()->paginate(9);
        return view('notes.trash', compact('notes'));
    }

    public function restore($id)
    {
        $note = Note::where('user_id', Auth::id())->onlyTrashed()->findOrFail($id);
        $note->restore();
        return redirect()->back()->with('success', 'Catatan berhasil dipulihkan!');
    }

    public function forceDelete($id)
    {
        $note = Note::where('user_id', Auth::id())->onlyTrashed()->findOrFail($id);
        if ($note->image) Storage::disk('public')->delete($note->image);
        $note->forceDelete();
        return redirect()->back()->with('success', 'Catatan dihapus permanen!');
    }
}
