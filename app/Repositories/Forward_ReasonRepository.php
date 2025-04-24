<?php

namespace App\Repositories;

use App\Models\Forward_Reason;
use App\Repositories\BaseRepository;

/**
 * Class Forward_ReasonRepository
 * @package App\Repositories
 * @version July 31, 2021, 9:55 am UTC
*/

class Forward_ReasonRepository extends BaseRepository
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
        return Forward_Reason::class;
    }
}
