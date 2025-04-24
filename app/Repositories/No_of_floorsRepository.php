<?php

namespace App\Repositories;

use App\Models\No_of_floors;
use App\Repositories\BaseRepository;

/**
 * Class No_of_floorsRepository
 * @package App\Repositories
 * @version July 27, 2021, 12:36 pm UTC
*/

class No_of_floorsRepository extends BaseRepository
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
        return No_of_floors::class;
    }
}
