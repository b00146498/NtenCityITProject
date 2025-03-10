<?php

namespace App\Repositories;

use App\Models\tpelog;
use App\Repositories\BaseRepository;

/**
 * Class tpelogRepository
 * @package App\Repositories
 * @version March 10, 2025, 2:25 pm UTC
*/

class tpelogRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'plan_id',
        'exercise_id',
        'num_sets',
        'num_reps',
        'minutes',
        'intensity',
        'incline',
        'times_per_week'
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
        return tpelog::class;
    }
}
