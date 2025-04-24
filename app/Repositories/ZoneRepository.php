<?php

namespace App\Repositories;

use App\Models\Zone;
use App\Repositories\BaseRepository;

/**
 * Class ZoneRepository
 * @package App\Repositories
 * @version September 29, 2021, 9:41 am UTC
*/

class ZoneRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'description'
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
        return Zone::class;
    }
}
