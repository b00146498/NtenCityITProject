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

    // ... [Keep all your existing web methods unchanged] ...

    /**
     * API: Get all clients (JSON response)
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiIndex(Request $request)
    {
        $user = auth()->user();
        
        // For employees - return only clients from their practice
        if ($user->role === 'employee') {
            $employee = \App\Models\Employee::where('userid', $user->id)->first();
            $clients = Client::where('practice_id', $employee->practice_id)
                ->select(['id', 'first_name', 'surname', 'email', 'account_status', 'practice_id'])
                ->get();
        } 
        // For clients - return only their own data
        elseif ($user->role === 'client') {
            $clients = Client::where('userid', $user->id)
                ->select(['id', 'first_name', 'surname', 'email', 'account_status', 'practice_id'])
                ->get();
        }
        // Admin/other cases
        else {
            $clients = Client::query()
                ->select(['id', 'first_name', 'surname', 'email', 'account_status', 'practice_id'])
                ->get();
        }

        return response()->json([
            'success' => true,
            'data' => $clients
        ]);
    }

    /**
     * API: Get single client (JSON response)
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiShow($id)
    {
        $user = auth()->user();
        $client = Client::find($id);

        if (!$client) {
            return response()->json([
                'success' => false,
                'message' => 'Client not found'
            ], 404);
        }

        // Authorization check
        if ($user->role === 'employee') {
            $employee = \App\Models\Employee::where('userid', $user->id)->first();
            if ($client->practice_id !== $employee->practice_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized'
                ], 403);
            }
        } 
        elseif ($user->role === 'client' && $client->userid !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        return response()->json([
            'success' => true,
            'data' => $client
        ]);
    }

    /**
     * API: Search clients (JSON response)
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiSearch(Request $request)
    {
        $query = $request->query('query');
        $user = auth()->user();

        $clientsQuery = Client::query()
            ->select(['id', 'first_name', 'surname', 'email', 'account_status']);

        // For employees - limit to their practice
        if ($user->role === 'employee') {
            $employee = \App\Models\Employee::where('userid', $user->id)->first();
            $clientsQuery->where('practice_id', $employee->practice_id);
        }

        if ($query) {
            $clientsQuery->where(function($q) use ($query) {
                $q->where('first_name', 'LIKE', "%{$query}%")
                  ->orWhere('surname', 'LIKE', "%{$query}%")
                  ->orWhere('email', 'LIKE', "%{$query}%");
            });
        }

        $clients = $clientsQuery->orderBy('first_name', 'asc')->get();

        return response()->json([
            'success' => true,
            'data' => $clients
        ]);
    }

    /**
     * API: Create new client (JSON response)
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiStore(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:50',
            'surname' => 'required|string|max:50',
            'email' => 'required|email|unique:clients,email',
            'practice_id' => 'required|exists:practices,id',
            // Add other validation rules as needed
        ]);

        try {
            $client = $this->clientRepository->create($validated);
            
            return response()->json([
                'success' => true,
                'data' => $client,
                'message' => 'Client created successfully'
            ], 201);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create client',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * API: Update client (JSON response)
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiUpdate(Request $request, $id)
    {
        $client = $this->clientRepository->find($id);

        if (!$client) {
            return response()->json([
                'success' => false,
                'message' => 'Client not found'
            ], 404);
        }

        $validated = $request->validate([
            'first_name' => 'sometimes|string|max:50',
            'surname' => 'sometimes|string|max:50',
            'email' => 'sometimes|email|unique:clients,email,'.$client->id,
            'practice_id' => 'sometimes|exists:practices,id',
            // Add other validation rules as needed
        ]);

        try {
            $client = $this->clientRepository->update($validated, $id);
            
            return response()->json([
                'success' => true,
                'data' => $client,
                'message' => 'Client updated successfully'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update client',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * API: Delete client (JSON response)
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiDestroy($id)
    {
        $client = $this->clientRepository->find($id);

        if (!$client) {
            return response()->json([
                'success' => false,
                'message' => 'Client not found'
            ], 404);
        }

        try {
            $this->clientRepository->delete($id);
            
            return response()->json([
                'success' => true,
                'message' => 'Client deleted successfully'
            ], 204);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete client',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}