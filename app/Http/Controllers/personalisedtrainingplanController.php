<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatepersonalisedtrainingplanRequest;
use App\Http\Requests\UpdatepersonalisedtrainingplanRequest;
use App\Repositories\personalisedtrainingplanRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Models\Personalisedtrainingplan;
use App\Models\Client;
use Flash;
use Response;

class personalisedtrainingplanController extends AppBaseController
{
    /** @var personalisedtrainingplanRepository $personalisedtrainingplanRepository*/
    private $personalisedtrainingplanRepository;

    public function __construct(personalisedtrainingplanRepository $personalisedtrainingplanRepo)
    {
        $this->personalisedtrainingplanRepository = $personalisedtrainingplanRepo;
    }

    /**
     * Display a listing of the personalisedtrainingplan.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $personalisedtrainingplans = $this->personalisedtrainingplanRepository->all();

        return view('personalisedtrainingplans.index')
            ->with('personalisedtrainingplans', $personalisedtrainingplans);

    }

    /**
     * Show the form for creating a new personalisedtrainingplan.
     *
     * @return Response
     */
    public function create()
    {
        $clients = Client::all();

        return view('personalisedtrainingplans.create', compact('clients'));
        //return view('personalisedtrainingplans.create');
    }

    /**
     * Store a newly created personalisedtrainingplan in storage.
     *
     * @param CreatepersonalisedtrainingplanRequest $request
     *
     * @return Response
     */
    public function store(CreatepersonalisedtrainingplanRequest $request)
    {
        $input = $request->all();

        $personalisedtrainingplan = $this->personalisedtrainingplanRepository->create($input);

        Flash::success('Personalised Training Plan saved successfully.');

        //return redirect(route('personalisedtrainingplans.index'));
        return redirect()->route('tpelogs.create', ['client_id' => $personalisedtrainingplan->client_id]);
    }

    /**
     * Display the specified personalisedtrainingplan.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $personalisedtrainingplan = $this->personalisedtrainingplanRepository->find($id);

        if (empty($personalisedtrainingplan)) {
            Flash::error('Personalised Training Plan not found');

            return redirect(route('personalisedtrainingplans.index'));
        }

        return view('personalisedtrainingplans.show')->with('personalisedtrainingplan', $personalisedtrainingplan);
    }

    /**
     * Show the form for editing the specified personalisedtrainingplan.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $personalisedtrainingplan = $this->personalisedtrainingplanRepository->find($id);

        if (empty($personalisedtrainingplan)) {
            Flash::error('Personalised Training Plan not found');

            return redirect(route('personalisedtrainingplans.index'));
        }

        return view('personalisedtrainingplans.edit')->with('personalisedtrainingplan', $personalisedtrainingplan);
    }

    /**
     * Update the specified personalisedtrainingplan in storage.
     *
     * @param int $id
     * @param UpdatepersonalisedtrainingplanRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatepersonalisedtrainingplanRequest $request)
    {
        $personalisedtrainingplan = $this->personalisedtrainingplanRepository->find($id);

        if (empty($personalisedtrainingplan)) {
            Flash::error('Personalised Training Plan not found');

            return redirect(route('personalisedtrainingplans.index'));
        }

        $personalisedtrainingplan = $this->personalisedtrainingplanRepository->update($request->all(), $id);

        Flash::success('Personalised Training Plan updated successfully.');

        return redirect(route('personalisedtrainingplans.index'));
    }

    /**
     * Remove the specified personalisedtrainingplan from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $personalisedtrainingplan = $this->personalisedtrainingplanRepository->find($id);

        if (empty($personalisedtrainingplan)) {
            Flash::error('Personalised Training Plan not found');

            return redirect(route('personalisedtrainingplans.index'));
        }

        $this->personalisedtrainingplanRepository->delete($id);

        Flash::success('Personalised Training Plan deleted successfully.');

        return redirect(route('personalisedtrainingplans.index'));
    }
    public function searchClients(Request $request)
    {
        $query = $request->input('query');

        $clients = Client::where('first_name', 'LIKE', "%{$query}%")
                        ->orWhere('surname', 'LIKE', "%{$query}%")
                        ->orderBy('first_name')
                        ->limit(10)
                        ->get(['id', 'first_name', 'surname']); // Select only necessary fields

        return response()->json($clients);
    }
}
