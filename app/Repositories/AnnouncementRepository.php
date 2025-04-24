<?php

namespace App\Repositories;

use App\Models\Announcement;
use App\Repositories\BaseRepository;

/**
 * Class AnnouncementRepository
 * @package App\Repositories
 * @version July 29, 2021, 5:07 am UTC
*/

class AnnouncementRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'title',
        'description',
        'image'
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
        return Announcement::class;
    }
}
