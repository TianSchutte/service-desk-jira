<?php

namespace TianSchutte\ServiceDeskJira\Contracts;

/**
 * Interface defining methods for managing utility services.
 */
interface UtilityManagerInterface
{
    /**
     * Returns all utility services.
     * @return mixed - all utility services.
     */
    public function getServices();

}
