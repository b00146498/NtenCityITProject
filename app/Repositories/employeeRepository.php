<?php

namespace App\Repositories;

use App\Models\employee;
use App\Repositories\BaseRepository;

/**
 * Class employeeRepository
 * @package App\Repositories
 * @version February 5, 2025, 10:15 pm UTC
*/

class employeeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'emp_first_name',
        'emp_surname',
        'date_of_birth',
        'gender',
        'contact_number',
        'emergency_contact',
        'email',
        'street',
        'city',
        'county',
        'pps_number',
        'role',
        'iban',
        'bic',
        'username',
        'password',
        'practice_id'
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
        return employee::class;
    }
}
