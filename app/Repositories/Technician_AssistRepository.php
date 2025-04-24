<?php

namespace App\Repositories;

use App\Models\Technician_Assist;
use App\Repositories\BaseRepository;

/**
 * Class Technician_AssistRepository
 * @package App\Repositories
 * @version September 30, 2021, 5:40 am UTC
*/

class Technician_AssistRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'title',
        'PDF'
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
        return Technician_Assist::class;
    }
}
