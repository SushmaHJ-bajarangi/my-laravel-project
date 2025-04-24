<?php

namespace App\Repositories;

use App\Models\team;
use App\Repositories\BaseRepository;

/**
 * Class teamRepository
 * @package App\Repositories
 * @version June 28, 2021, 12:36 pm UTC
*/

class teamRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'title',
        'name',
        'email',
        'password',
        'contact_number'
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
        return team::class;
    }
}
