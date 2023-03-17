<?php

namespace TianSchutte\ServiceDeskJira\Contracts;

/**
 * Interface defining methods for managing request types.
 */
interface TypeManagerInterface
{
    /**
     * Returns all request types.
     * @return mixed
    */
    public function getTypes();

    /**
     * Returns the request type with the specified ID.
     * @param string $requestTypeId - The ID of the request type to retrieve.
     * @return mixed - The request type with the specified ID.
     */
    public function getTypeById(string $requestTypeId);

    /**
     * Creates a new request type with the specified data.
     * @param array $data - The data to create the request type.
     * @return mixed - The newly created request type.
     */
    public function createType(array $data);

    /**
     * Returns an array of fields for the specified request type ID.
     * @param string $requestTypeId - The ID of the request type to retrieve fields.
     * @return mixed  - fields for the specified request type ID.
     */
    public function getFields(string $requestTypeId);

    /**
     * Returns   all type groups.
     * @return mixed - all type groups.
    */
    public function getTypeGroup();

    /**
     * Returns fields for the request type with the specified ID.
     * @param string $requestTypeId - The ID of the request type to retrieve fields from.
     * @return mixed - fields for the request type with the specified ID.
     */
    public function getTypeFields(string $requestTypeId);

}
