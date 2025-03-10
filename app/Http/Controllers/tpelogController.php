<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatetpelogRequest;
use App\Http\Requests\UpdatetpelogRequest;
use App\Repositories\tpelogRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Models\Tpelog;
use App\Models\standardexercises;
use Flash;
use Response;

class tpelogController extends AppBaseController
{
    /** @var tpelogRepository $tpelogRepository*/
    private $tpelogRepository;

    public function __construct(tpelogRepository $tpelogRepo)
    {
        $this->tpelogRepository = $tpelogRepo;
    }

    /**
     * Display a listing of the tpelog.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        //$tpelogs = $this->tpelogRepository->all();

        //return view('tpelogs.index')
            //->with('tpelogs', $tpelogs);
        $tpelogs = Tpelog::with('exercise')->get();

        return view('tpelogs.index', compact('tpelogs'));
    }

    /**
     * Show the form for creating a new tpelog.
     *
     * @return Response
     */
    public function create()
    {
        $exercises = standardexercises::all();
        //return view('tpelogs.create');
        return view('tpelogs.create', compact('exercises'));
    }
    

    /**
     * Store a newly created tpelog in storage.
     *
     * @param CreatetpelogRequest $request
     *
     * @return Response
     */
    public function store(CreatetpelogRequest $request)
    {
        //$input = $request->all();

        //$tpelog = $this->tpelogRepository->create($input);

        //Flash::success('Tpelog saved successfully.');

        //return redirect(route('tpelogs.index'));
        $validated = $request->validate([
            'plan_id' => 'required|exists:personalisedtrainingplan,id',
            'exercise_id' => 'required|exists:standardexercises,id',
            'num_sets' => 'required|integer|min:1',
            'num_reps' => 'required|integer|min:1',
            'minutes' => 'nullable|integer|min:0',
            'incline' => 'required|numeric|min:-20|max:20', // Allow decline (negative values)
        ]);
    
        Tpelog::create($validated);
    
        return redirect()->route('tpelogs.index')->with('success', 'Exercise added successfully!');
    }

    /**
     * Display the specified tpelog.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $tpelog = $this->tpelogRepository->find($id);

        if (empty($tpelog)) {
            Flash::error('Tpelog not found');

            return redirect(route('tpelogs.index'));
        }

        return view('tpelogs.show')->with('tpelog', $tpelog);
    }

    /**
     * Show the form for editing the specified tpelog.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $tpelog = $this->tpelogRepository->find($id);

        if (empty($tpelog)) {
            Flash::error('Tpelog not found');

            return redirect(route('tpelogs.index'));
        }

        return view('tpelogs.edit')->with('tpelog', $tpelog);
    }

    /**
     * Update the specified tpelog in storage.
     *
     * @param int $id
     * @param UpdatetpelogRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatetpelogRequest $request)
    {
        $tpelog = $this->tpelogRepository->find($id);

        if (empty($tpelog)) {
            Flash::error('Tpelog not found');

            return redirect(route('tpelogs.index'));
        }

        $tpelog = $this->tpelogRepository->update($request->all(), $id);

        Flash::success('Tpelog updated successfully.');

        return redirect(route('tpelogs.index'));
    }

    /**
     * Remove the specified tpelog from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $tpelog = $this->tpelogRepository->find($id);

        if (empty($tpelog)) {
            Flash::error('Tpelog not found');

            return redirect(route('tpelogs.index'));
        }

        $this->tpelogRepository->delete($id);

        Flash::success('Tpelog deleted successfully.');

        return redirect(route('tpelogs.index'));
    }
}
