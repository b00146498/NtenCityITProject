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
     * Show the form for creating a new practice.
     *
     * @return Response
     */
    public function create()
    {
        return view('practices.create');
    }

    /**
     * Store a newly created practice in storage.
     *
     * @param CreatepracticeRequest $request
     *
     * @return Response
     */
    public function store(CreatepracticeRequest $request)
    {
        $input = $request->all();

        $practice = $this->practiceRepository->create($input);

        Flash::success('Practice saved successfully.');

        return redirect(route('practices.index'));
    }

    /**
     * Display the specified practice.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $practice = $this->practiceRepository->find($id);

        if (empty($practice)) {
            Flash::error('Practice not found');

            return redirect(route('practices.index'));
        }

        return view('practices.show')->with('practice', $practice);
    }

    /**
     * Show the form for editing the specified practice.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $practice = $this->practiceRepository->find($id);

        if (empty($practice)) {
            Flash::error('Practice not found');

            return redirect(route('practices.index'));
        }

        return view('practices.edit')->with('practice', $practice);
    }

    /**
     * Update the specified practice in storage.
     *
     * @param int $id
     * @param UpdatepracticeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatepracticeRequest $request)
    {
        $practice = $this->practiceRepository->find($id);

        if (empty($practice)) {
            Flash::error('Practice not found');

            return redirect(route('practices.index'));
        }

        $practice = $this->practiceRepository->update($request->all(), $id);

        Flash::success('Practice updated successfully.');

        return redirect(route('practices.index'));
    }

    /**
     * Remove the specified practice from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $practice = $this->practiceRepository->find($id);

        if (empty($practice)) {
            Flash::error('Practice not found');

            return redirect(route('practices.index'));
        }

        $this->practiceRepository->delete($id);

        Flash::success('Practice deleted successfully.');

        return redirect(route('practices.index'));
    }
}
