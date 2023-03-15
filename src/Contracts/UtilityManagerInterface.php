<?php

namespace TianSchutte\ServiceDeskJira\Contracts;

interface UtilityManagerInterface
{
    public function getServices();

    public function getUsers();

    public function getUserTickets($userEmail);
}
