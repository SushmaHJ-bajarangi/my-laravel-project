<?php

namespace App\Repositories;

use App\Models\ServicesList;
use App\Repositories\BaseRepository;

/**
 * Class ServicesListRepository
 * @package App\Repositories
 * @version September 22, 2021, 6:46 am UTC
*/

class ServicesListRepository extends BaseRepository
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
        return ServicesList::class;
    }
}
