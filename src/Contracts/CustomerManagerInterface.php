<?php

namespace TianSchutte\ServiceDeskJira\Contracts;

interface CustomerManagerInterface
{
    public function createCustomer($userEmail, $fullName);

    public function addCustomerToServiceDesk($userEmail, $serviceDeskId);

    public function getCustomers();

    public function getCustomerTickets($userEmail);

}