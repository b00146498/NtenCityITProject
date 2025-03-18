<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateclientRequest;
use App\Http\Requests\UpdateclientRequest;
use App\Repositories\clientRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Models\Practice;
use App\Models\Client;
use Flash;
use Response;

class clientController extends AppBaseController
{
    /** @var clientRepository $clientRepository*/
    private $clientRepository;

    public function __construct(clientRepository $clientRepo)
    {
        $this->clientRepository = $clientRepo;
    }

    /**
     * Display a listing of the client.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $clients = $this->clientRepository->all();

        return view('clients.index')
            ->with('clients', $clients);
    }

    /**
     * Show the form for creating a new client.
     *
     * @return Response
     */
    public function create()
    {
        $practices = \App\Models\Practice::all();
        
        $practice_id = $practices->first()->id;

        //$client = new \App\Models\Client();
        
        return view('clients.create')->with([
            //'client' => $client, 
            'practices' => $practices, 
            //'practice_id' => $practice_id 
        ]);
        //return view('clients.create');
    }

    public function new($userid)
    {
        $practices = \App\Models\Practice::all();
        
        $practice_id = $practices->first()->id;
        
        return view('clients.new')->with([
            //'client' => $client, 
            'practices' => $practices, 
            'userid' => $userid 
        ]);
        //return view('clients.create');
    }
    /**
     * Store a newly created client in storage.
     *
     * @param CreateclientRequest $request
     *
     * @return Response
     */
    public function store(CreateclientRequest $request)
    {
        $input = $request->all();

        $client = $this->clientRepository->create($input);

        Flash::success('Client saved successfully.');

        return redirect()->route('client.clientdashboard');
    }

    /**
     * Display the specified client.
     *
     * @param int $id
     *
     * @return Response
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
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $client = $this->clientRepository->find($id);

        if (empty($client)) {
            Flash::error('Client not found');

            return redirect(route('clients.index'));
        }

        $practices = Practice::all();

        return view('clients.edit', compact('client', 'practices'));
    }


    /**
     * Update the specified client in storage.
     *
     * @param int $id
     * @param UpdateclientRequest $request
     *
     * @return Response
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
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
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
    public function searchClients(Request $request)
    {
        $query = $request->query('query');

        // Fetch clients matching the search query
        $clients = Client::where('first_name', 'LIKE', "%{$query}%")
                        ->orWhere('surname', 'LIKE', "%{$query}%")
                        ->orderBy('first_name', 'asc')
                        ->get(['id', 'first_name', 'surname']);

        return response()->json($clients);
    }
    public function clientdashboard()
    {
        return view('clients.clientdashboard');
    }


}
