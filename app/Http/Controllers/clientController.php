<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateclientRequest;
use App\Http\Requests\UpdateclientRequest;
use App\Repositories\clientRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;
use App\Models\Practice; 
use Illuminate\Support\Facades\Auth;

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
        $practices = Practice::all(); // ✅ Fetch all practices
        
        // ✅ Use `$practices` instead of `$practice`
        $practice_id = $practices->first() ? $practices->first()->id : null;

        $client = new \App\Models\Client();

        return view('clients.create')->with([
            'client' => $client, // ✅ Pass empty client
            'practices' => $practices, // ✅ Fix variable name
            'practice_id' => $practice_id 
        ]);
    }

    

    /**
     * Store a newly created client in storage.
     */
    public function store(CreateclientRequest $request)
    {
        $user = Auth::user(); // Get logged-in user

        // Split the user's full name into first name & surname
        $nameParts = explode(' ', $user->name, 2);
        $firstName = $nameParts[0]; // First word is first name
        $surname = isset($nameParts[1]) ? $nameParts[1] : ''; // Everything else is surname

        // Get all request input and modify first_name & surname
        $input = $request->all();
        $input['first_name'] = $firstName; // 
        $input['surname'] = $surname; // 
        $input['email'] = $user->email; // 
        $input['userid'] = $user->id; // 

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
    public function getLoggedInClientDetails()
    {
        if (!Auth::guest()){
            $user = Auth::user();
            echo "Userid is " . $user->id;
            echo "Client id is " . $user->client->id;
            echo "The client's name is " . $user->client->first_name . " ";
            echo $user->client->surname;
        }
        else {
            echo "not logged in ";
        }
    }
}
