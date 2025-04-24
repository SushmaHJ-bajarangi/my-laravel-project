<?php

namespace App\Repositories;

use App\Models\LopType;
use App\Repositories\BaseRepository;

/**
 * Class LopTypeRepository
 * @package App\Repositories
 * @version July 27, 2021, 12:15 pm UTC
*/

class LopTypeRepository extends BaseRepository
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
        return LopType::class;
    }
}
