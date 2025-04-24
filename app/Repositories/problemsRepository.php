<?php

namespace App\Repositories;

use App\Models\problems;
use App\Repositories\BaseRepository;

/**
 * Class problemsRepository
 * @package App\Repositories
 * @version July 16, 2021, 4:30 am UTC
*/

class problemsRepository extends BaseRepository
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
        return problems::class;
    }
}
