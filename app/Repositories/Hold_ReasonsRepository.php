<?php

namespace App\Repositories;

use App\Models\Hold_Reasons;
use App\Repositories\BaseRepository;

/**
 * Class Hold_ReasonsRepository
 * @package App\Repositories
 * @version August 6, 2021, 11:08 am UTC
*/

class Hold_ReasonsRepository extends BaseRepository
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
        return Hold_Reasons::class;
    }
}
