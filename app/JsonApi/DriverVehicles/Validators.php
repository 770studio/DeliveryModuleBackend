<?php

namespace App\JsonApi\DriverVehicles;

use CloudCreativity\LaravelJsonApi\Validation\AbstractValidators;
use CloudCreativity\LaravelJsonApi\Contracts\Validation\ValidatorInterface;
use App\Driver;

class Validators extends AbstractValidators
{

    /**
     * The include paths a client is allowed to request.
     *
     * @var string[]|null
     *      the allowed paths, an empty array for none allowed, or null to allow all paths.
     */
    protected $allowedIncludePaths = [];

    /**
     * The sort field names a client is allowed send.
     *
     * @var string[]|null
     *      the allowed fields, an empty array for none allowed, or null to allow all fields.
     */
    protected $allowedSortParameters = null; //[];

    /**
     * The filters a client is allowed send.
     *
     * @var string[]|null
     *      the allowed filters, an empty array for none allowed, or null to allow all.
     */
    protected $allowedFilteringParameters = null; //[];

    /**
     * Get resource validation rules.
     *
     * @param mixed|null $record
     *      the record being updated, or null if creating a resource.
     * @return mixed
     */
    protected function rules($record = null): array
    {
        return [
            //
        ];
    }

    /**
     * Get query parameter validation rules.
     *
     * @return array
     */
    protected function queryRules(): array
    {
        return [
            //
        ];
    }





    public function update($record, array $document): ValidatorInterface
    {
        $validator = parent::update($record, $document);


        //dd($record, 88888888888, $document);
        $order_id = $document['data']['attributes']['order_id'];
        $order_status = $document['data']['attributes']['order_status'];

        if($order_id != $record->order_id ) {
            // updating order_id
            $validator->sometimes('order-id-update', 'required', function ($input) {
                dd($input);
                return !Driver::where('order_id', $order_id)->exists();


            });

        }
        if($order_status != $record->order_status ) {
            // updating order_status
        }




        return $validator;
    }









}
