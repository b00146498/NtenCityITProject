<?php

namespace App\Repositories;

use App\Models\client;
use App\Repositories\BaseRepository;

/**
 * Class clientRepository
 * @package App\Repositories
 * @version February 5, 2025, 10:15 pm UTC
*/

class clientRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'first_name',
        'surname',
        'date_of_birth',
        'gender',
        'email',
        'contact_number',
        'street',
        'city',
        'county',
        'username',
        'password',
        'account_status',
        'practice_id',
        'userid'
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
        return client::class;
    }
}
