<?php

namespace App\Repositories;

use App\Models\BackupTeam;
use App\Repositories\BaseRepository;

/**
 * Class BackupTeamRepository
 * @package App\Repositories
 * @version November 29, 2021, 3:03 pm IST
*/

class BackupTeamRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'title',
        'name',
        'email',
        'number',
        'zone'
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
        return BackupTeam::class;
    }
}
