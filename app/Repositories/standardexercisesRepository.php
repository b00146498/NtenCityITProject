<?php

namespace App\Repositories;

use App\Models\standardexercises;
use App\Repositories\BaseRepository;

/**
 * Class standardexercisesRepository
 * @package App\Repositories
 * @version March 10, 2025, 2:24 pm UTC
*/

class standardexercisesRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'exercise_name',
        'exercise_video_link',
        'target_body_area'
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
        return standardexercises::class;
    }
}
