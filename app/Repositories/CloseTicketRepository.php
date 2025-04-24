<?php

namespace App\Repositories;

use App\Models\CloseTicket;
use App\Repositories\BaseRepository;

/**
 * Class CloseTicketRepository
 * @package App\Repositories
 * @version September 21, 2021, 11:37 am UTC
*/

class CloseTicketRepository extends BaseRepository
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
        return CloseTicket::class;
    }
}
