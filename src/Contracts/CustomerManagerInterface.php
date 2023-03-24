<?php

namespace TianSchutte\ServiceDeskJira\Contracts;

/**
 * Interface defining methods for managing customers.
 */
interface CustomerManagerInterface
{
    /**
     * Creates a new customer with the specified email and full name.
     * @param string $userEmail The email of the customer.
     * @param string $fullName The full name of the customer.
     * @return mixed
     */
    public function createCustomer(string $userEmail, string $fullName);

    /**
     * Adds an existing customer to the service desk.
     * @param string $userEmail The email of the customer to add.
     * @return mixed
     */
    public function addCustomerToServiceDesk(string $userEmail);

    /**
     * Returns all customers.
     * @return mixed
     */
    public function getCustomers();

    /**
     * Returns the customer with the specified email.
     * @param string $customerEmail The email of the customer.
     * @return mixed
     */
    public function getCustomerByEmail(string $customerEmail);

    /**
     * Returns tickets for the specified customer email.
     * @param string $userEmail The email of the customer.
     * @return mixed
     */
    public function getCustomerTickets(string $userEmail);

}