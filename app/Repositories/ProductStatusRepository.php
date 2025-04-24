<?php

namespace App\Repositories;

use App\Models\ProductStatus;
use App\Repositories\BaseRepository;

/**
 * Class ProductStatusRepository
 * @package App\Repositories
 * @version September 27, 2021, 9:36 am UTC
*/

class ProductStatusRepository extends BaseRepository
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
        return ProductStatus::class;
    }
}
