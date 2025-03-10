<?php

namespace App\Repositories;

use App\Models\personalisedtrainingplan;
use App\Repositories\BaseRepository;

/**
 * Class personalisedtrainingplanRepository
 * @package App\Repositories
 * @version March 10, 2025, 2:25 pm UTC
*/

class personalisedtrainingplanRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'client_id',
        'start_date',
        'end_date'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return personalisedtrainingplan::class;
    }
}
