<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DiaryEntry;
use App\Models\Client;

class DiaryEntryController extends Controller
{
    /**
     * Display a listing of the diary entries for a client.
     */
    public function index($client_id)
    {
        // Ensure the client exists
        $client = Client::findOrFail($client_id);

        // Fetch all diary entries for this client
        $diaryEntries = $client->diaryEntries()->latest()->get();

        return view('diary_entries.index', compact('client', 'diaryEntries'));
    }

    /**
     * Show the form for creating a new diary entry.
     */
    public function create($client_id)
    {
        $client = Client::findOrFail($client_id);

        return view('diary_entries.create', compact('client'));
    }

    /**
     * Store a newly created diary entry in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'content' => 'required|string',
        ]);

        DiaryEntry::create([
            'employee_id' => Auth::id(), // Corrected: Use Auth::id() instead of Auth::user()->id
            'client_id' => $request->client_id,
            'entry_date' => now(),
            'content' => $request->content,
        ]);

        // Redirect to diary entries list instead of clients.show
        return redirect()->route('diary-entries.index', $request->client_id)->with('success', 'Diary entry added.');
    }

    /**
     * Display the specified diary entry.
     */
    public function show($id)
    {
        $diaryEntry = DiaryEntry::findOrFail($id);
        $client = $diaryEntry->client; // Fetch client details

        return view('diary_entries.show', compact('diaryEntry', 'client'));
    }

    /**
     * Show the form for editing a diary entry.
     */
    public function edit($id)
    {
        $diaryEntry = DiaryEntry::findOrFail($id);

        // Ensure only the assigned employee can edit
        if ((int) $diaryEntry->employee_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('diary_entries.edit', compact('diaryEntry'));
    }

    /**
     * Update the specified diary entry in storage.
     */
    public function update(Request $request, $id)
    {
        $diaryEntry = DiaryEntry::findOrFail($id);

        // Ensure only the assigned employee can update
        if ((int) $diaryEntry->employee_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'content' => 'required|string',
        ]);

        $diaryEntry->update([
            'content' => $request->content,
        ]);

        return redirect()->route('diary-entries.index', $diaryEntry->client_id)->with('success', 'Diary entry updated.');
    }

    /**
     * Remove the specified diary entry from storage.
     */
    public function destroy($id)
    {
        $diaryEntry = DiaryEntry::findOrFail($id);

        // Ensure only the assigned employee can delete
        if ((int) $diaryEntry->employee_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $diaryEntry->delete();
        return redirect()->back()->with('success', 'Diary entry deleted.');
    }
}