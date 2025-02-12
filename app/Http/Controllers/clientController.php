<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateclientRequest;
use App\Http\Requests\UpdateclientRequest;
use App\Repositories\clientRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;
use App\Models\Practice; // Added to fetch practice names

class clientController extends AppBaseController
{
    /** @var clientRepository $clientRepository */
    private $clientRepository;

    public function __construct(clientRepository $clientRepo)
    {
        $this->clientRepository = $clientRepo;
    }

    /**
     * Display a listing of the client.
     */
    public function index(Request $request)
    {
        $clients = $this->clientRepository->all();

        return view('clients.index')->with('clients', $clients);
    }

    /**
     * Show the form for creating a new client.
     */
    public function create()
    {
        $practices = Practice::all(); // Fetch all practices
    
        // Automatically select the first available practice_id (if exists)
        $practice_id = $practices->first() ? $practices->first()->id : null;
    
        return view('clients.create')->with([
            'practices' => $practices,
            'practice_id' => $practice_id // Pass this to the form
        ]);
    }
    

    /**
     * Store a newly created client in storage.
     */
    public function store(CreateclientRequest $request)
    {
        $input = $request->all();

        $client = $this->clientRepository->create($input);

        Flash::success('Client saved successfully.');

        return redirect(route('clients.index'));
    }

    /**
     * Display the specified client.
     */
    public function show($id)
    {
        $client = $this->clientRepository->find($id);

        if (empty($client)) {
            Flash::error('Client not found');
            return redirect(route('clients.index'));
        }

        return view('clients.show')->with('client', $client);
    }

    /**
     * Show the form for editing the specified client.
     */
    public function edit($id)
    {
        $client = $this->clientRepository->find($id);

        if (empty($client)) {
            Flash::error('Client not found');
            return redirect(route('clients.index'));
        }

        $practices = Practice::all(); // Fetch practices for the dropdown

        return view('clients.edit')->with([
            'client' => $client,
            'practices' => $practices
        ]);
    }

    /**
     * Update the specified client in storage.
     */
    public function update($id, UpdateclientRequest $request)
    {
        $client = $this->clientRepository->find($id);

        if (empty($client)) {
            Flash::error('Client not found');
            return redirect(route('clients.index'));
        }

        $client = $this->clientRepository->update($request->all(), $id);

        Flash::success('Client updated successfully.');

        return redirect(route('clients.index'));
    }

    /**
     * Remove the specified client from storage.
     */
    public function destroy($id)
    {
        $client = $this->clientRepository->find($id);

        if (empty($client)) {
            Flash::error('Client not found');
            return redirect(route('clients.index'));
        }

        $this->clientRepository->delete($id);

        Flash::success('Client deleted successfully.');

        return redirect(route('clients.index'));
    }
}
