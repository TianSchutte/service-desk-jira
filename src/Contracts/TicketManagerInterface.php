<?php

namespace TianSchutte\ServiceDeskJira\Contracts;

interface TicketManagerInterface
{
    public function getTypes(string $serviceDeskId);
    public function getTypeById(string $serviceDeskId, string $requestTypeId);
    public function createType(string $serviceDeskId, array $data);
    public function getFields(string $serviceDeskId, string $requestTypeId);
    public function getTypeGroup(string $serviceDeskId);
    public function getTypeFields(string $serviceDeskId, string $requestTypeId);
}
