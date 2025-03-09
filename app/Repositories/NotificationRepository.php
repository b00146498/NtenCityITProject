<?php

namespace App\Repositories;

use App\Models\Notification;
use App\Repositories\BaseRepository;

/**
 * Class NotificationRepository
 * @package App\Repositories
 * @version March 9, 2025, 7:06 pm UTC
*/

class NotificationRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'type',
        'notifiable_type',
        'notifiable_id',
        'data',
        'read_at'
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
        return Notification::class;
    }
}
