<?php

namespace TianSchutte\ServiceDeskJira\Contracts;

interface DeskManagerInterface
{
    public function getInfo();

    public function getServiceDesks();

    public function getServiceDesk();

    public function getQueues();

    public function getIssuesInQueue($queueId);

}
