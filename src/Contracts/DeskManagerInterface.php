<?php

namespace TianSchutte\ServiceDeskJira\Contracts;

/**
 * Interface defining methods for managing service desks.
 */
interface DeskManagerInterface
{
    /**
     * Returns information about the service desk.
     * @return mixed
     */
    public function getInfo();

    /**
     * Returns all service desks.
     * @return mixed
     */
    public function getServiceDesks();

    /**
     * Returns the service desk with the specified ID.
     * @return mixed
     */
    public function getServiceDesk();

    /**
     * Returns an array of all queues.
     * @return mixed
     */
    public function getQueues();

    /**
     * Returns all issues in the specified queue.
     * @param $queueId - The ID of the queue.
     * @return mixed
     */
    public function getIssuesInQueue($queueId);

}
