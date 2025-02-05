<?php

namespace App\Repositories;

use App\Models\practice;
use App\Repositories\BaseRepository;

/**
 * Class practiceRepository
 * @package App\Repositories
 * @version February 5, 2025, 10:16 pm UTC
*/

class practiceRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'company_name',
        'company_type',
        'street',
        'city',
        'county',
        'iban',
        'bic'
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
        return practice::class;
    }
}
