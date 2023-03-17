<?php

namespace TianSchutte\ServiceDeskJira\Contracts;

interface TypeManagerInterface
{
    public function getTypes();

    public function getTypeById(string $requestTypeId);

    public function createType(array $data);

    public function getFields(string $requestTypeId);

    public function getTypeGroup();

    public function getTypeFields(string $requestTypeId);

}
