<?php

namespace App\Repositories;

use App\Models\customer_products;
use App\Repositories\BaseRepository;

/**
 * Class customer_productsRepository
 * @package App\Repositories
 * @version June 30, 2021, 7:51 am UTC
*/

class customer_productsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'customer_id',

        'model_id',

        'area',

        'noofstops',

        'door',

        'number_of_floors',

        'cop_type',

        'lop_type',

        'passenger_capacity',

        'distance',

        'unique_job_number',

        'warranty_start_date',

        'warranty_end_date'
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
        return customer_products::class;
    }
}
