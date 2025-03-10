<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatestandardexercisesRequest;
use App\Http\Requests\UpdatestandardexercisesRequest;
use App\Repositories\standardexercisesRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Models\StandardExercises;
use Flash;
use Response;

class standardexercisesController extends AppBaseController
{
    /** @var standardexercisesRepository $standardexercisesRepository*/
    private $standardexercisesRepository;

    public function __construct(standardexercisesRepository $standardexercisesRepo)
    {
        $this->standardexercisesRepository = $standardexercisesRepo;
    }

    /**
     * Display a listing of the standardexercises.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $standardexercises = $this->standardexercisesRepository->all();

        return view('standardexercises.index')
            ->with('standardexercises', $standardexercises);
    }

    /**
     * Show the form for creating a new standardexercises.
     *
     * @return Response
     */
    public function create()
    {
        return view('standardexercises.create');
    }

    /**
     * Store a newly created standardexercises in storage.
     *
     * @param CreatestandardexercisesRequest $request
     *
     * @return Response
     */
    public function store(CreatestandardexercisesRequest $request)
    {
        $input = $request->all();

        $standardexercises = $this->standardexercisesRepository->create($input);

        Flash::success('Standardexercises saved successfully.');

        return redirect(route('standardexercises.index'));
    }

    /**
     * Display the specified standardexercises.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $standardexercises = $this->standardexercisesRepository->find($id);

        if (empty($standardexercises)) {
            Flash::error('Standardexercises not found');

            return redirect(route('standardexercises.index'));
        }

        return view('standardexercises.show')->with('standardexercises', $standardexercises);
    }

    /**
     * Show the form for editing the specified standardexercises.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $standardexercises = $this->standardexercisesRepository->find($id);

        if (empty($standardexercises)) {
            Flash::error('Standardexercises not found');

            return redirect(route('standardexercises.index'));
        }

        return view('standardexercises.edit')->with('standardexercises', $standardexercises);
    }

    /**
     * Update the specified standardexercises in storage.
     *
     * @param int $id
     * @param UpdatestandardexercisesRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatestandardexercisesRequest $request)
    {
        $standardexercises = $this->standardexercisesRepository->find($id);

        if (empty($standardexercises)) {
            Flash::error('Standardexercises not found');

            return redirect(route('standardexercises.index'));
        }

        $standardexercises = $this->standardexercisesRepository->update($request->all(), $id);

        Flash::success('Standardexercises updated successfully.');

        return redirect(route('standardexercises.index'));
    }

    /**
     * Remove the specified standardexercises from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $standardexercises = $this->standardexercisesRepository->find($id);

        if (empty($standardexercises)) {
            Flash::error('Standardexercises not found');

            return redirect(route('standardexercises.index'));
        }

        $this->standardexercisesRepository->delete($id);

        Flash::success('Standardexercises deleted successfully.');

        return redirect(route('standardexercises.index'));
    }
}
