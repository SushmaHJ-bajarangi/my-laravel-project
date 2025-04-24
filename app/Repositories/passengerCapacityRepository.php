<?php

namespace App\Repositories;

use App\Models\passengerCapacity;
use App\Repositories\BaseRepository;

/**
 * Class passengerCapacityRepository
 * @package App\Repositories
 * @version July 27, 2021, 12:35 pm UTC
*/

class passengerCapacityRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'title'
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
        return passengerCapacity::class;
    }
}
