<?php

namespace App\Repositories;

use App\Models\CopType;
use App\Repositories\BaseRepository;

/**
 * Class CopTypeRepository
 * @package App\Repositories
 * @version July 27, 2021, 12:34 pm UTC
*/

class CopTypeRepository extends BaseRepository
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
        return CopType::class;
    }
}
