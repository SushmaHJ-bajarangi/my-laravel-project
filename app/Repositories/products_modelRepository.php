<?php

namespace App\Repositories;

use App\Models\products_model;
use App\Repositories\BaseRepository;

/**
 * Class products_modelRepository
 * @package App\Repositories
 * @version June 30, 2021, 7:17 am UTC
*/

class products_modelRepository extends BaseRepository
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
        return products_model::class;
    }
}
