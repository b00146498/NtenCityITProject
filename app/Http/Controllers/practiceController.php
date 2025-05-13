<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatepracticeRequest;
use App\Http\Requests\UpdatepracticeRequest;
use App\Repositories\practiceRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class practiceController extends AppBaseController
{
    /** @var practiceRepository $practiceRepository*/
    private $practiceRepository;

    public function __construct(practiceRepository $practiceRepo)
    {
        $this->practiceRepository = $practiceRepo;
    }

    /**
     * Display a listing of the practice.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $practices = $this->practiceRepository->all();

        // Return JSON if requested (for AJAX dropdown)
        if ($request->get('format') === 'json') {
            return response()->json($practices);
        }

        return view('practices.index')
            ->with('practices', $practices);
    }

    /**
     * API: Get all practices (paginated JSON response)
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiIndex(Request $request)
    {
        $perPage = $request->query('perPage', 15);
        $practices = $this->practiceRepository->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $practices->items(),
            'meta' => [
                'current_page' => $practices->currentPage(),
                'per_page' => $practices->perPage(),
                'total' => $practices->total(),
                'last_page' => $practices->lastPage()
            ]
        ]);
    }

    /**
     * API: Get single practice details
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiShow($id)
    {
        $practice = $this->practiceRepository->find($id);

        if (!$practice) {
            return response()->json([
                'success' => false,
                'message' => 'Practice not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $practice
        ]);
    }

    /**
     * API: Create new practice
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiStore(Request $request)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'company_type' => 'required|string',
            'street' => 'required|string',
            'city' => 'required|string',
            'county' => 'required|string',
            'iban' => 'required|string',
            'bic' => 'required|string'
        ]);

        try {
            $practice = $this->practiceRepository->create($validated);
            
            return response()->json([
                'success' => true,
                'data' => $practice,
                'message' => 'Practice created successfully'
            ], 201);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create practice',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * API: Update practice
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiUpdate(Request $request, $id)
    {
        $practice = $this->practiceRepository->find($id);

        if (!$practice) {
            return response()->json([
                'success' => false,
                'message' => 'Practice not found'
            ], 404);
        }

        $validated = $request->validate([
            'company_name' => 'sometimes|string|max:255',
            'company_type' => 'sometimes|string',
            'street' => 'sometimes|string',
            'city' => 'sometimes|string',
            'county' => 'sometimes|string',
            'iban' => 'sometimes|string',
            'bic' => 'sometimes|string'
        ]);

        try {
            $practice = $this->practiceRepository->update($validated, $id);
            
            return response()->json([
                'success' => true,
                'data' => $practice,
                'message' => 'Practice updated successfully'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update practice',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * API: Delete practice
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiDestroy($id)
    {
        $practice = $this->practiceRepository->find($id);

        if (!$practice) {
            return response()->json([
                'success' => false,
                'message' => 'Practice not found'
            ], 404);
        }

        try {
            $this->practiceRepository->delete($id);
            
            return response()->json([
                'success' => true,
                'message' => 'Practice deleted successfully'
            ], 204);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete practice',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // ... [Keep all your existing web methods unchanged below this line] ...
    // The following methods remain exactly as they were in your original file:
    // create(), store(), show(), edit(), update(), destroy()
}