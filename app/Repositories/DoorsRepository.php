<?php

namespace App\Repositories;

use App\Models\Doors;
use App\Repositories\BaseRepository;

/**
 * Class DoorsRepository
 * @package App\Repositories
 * @version July 27, 2021, 12:33 pm UTC
*/

class DoorsRepository extends BaseRepository
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
        return Doors::class;
    }
}
