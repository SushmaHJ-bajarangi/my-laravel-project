<?php

namespace App\Repositories;

use App\Models\parts;
use App\Repositories\BaseRepository;

/**
 * Class partsRepository
 * @package App\Repositories
 * @version June 29, 2021, 12:45 pm UTC
*/

class partsRepository extends BaseRepository
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
        return parts::class;
    }
}
