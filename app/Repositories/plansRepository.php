<?php

namespace App\Repositories;

use App\Models\plans;
use App\Repositories\BaseRepository;

/**
 * Class plansRepository
 * @package App\Repositories
 * @version June 30, 2021, 4:59 am UTC
*/

class plansRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'title',
        'decsription'
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
        return plans::class;
    }
}
