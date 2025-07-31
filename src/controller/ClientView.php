<?php

namespace controller;

class ClientView
{
    /**
     * Retrieves a list of portfolio items (photos, graphic designs) based on filters.
     *
     * @param string|null $category Optional category to filter by (e.g., 'weddings', 'logos').
     * @param int         $limit    Optional number of items to retrieve.
     * @param int         $offset   Optional offset for pagination.
     * @return array An array of portfolio item data.
     */
    public function getPortfolioItems(?string $category = null, int $limit = 12, int $offset = 0): array
    {
        // This method would fetch data from a database or file system
        // based on category, limit, and offset.
        // It would return an array of objects or associative arrays,
        // each representing a portfolio item.
        return [];
    }

    /**
     * Retrieves details for a specific portfolio item.
     *
     * @param string $itemId The unique ID or slug of the portfolio item.
     * @return object|null An object representing the portfolio item, or null if not found.
     */
    public function getPortfolioItemDetails(string $itemId): ?object
    {
        // This method would fetch the detailed information for a single portfolio item.
        return null;
    }

    /**
     * Retrieves a list of all available service categories.
     *
     * @return array An array of strings representing category names.
     */
    public function getPortfolioCategories(): array
    {
        // This would fetch distinct categories for filtering the portfolio.
        return [];
    }

    /**
     * Retrieves a list of all services offered.
     *
     * @return array An array of service data (e.g., service name, description, basic price).
     */
    public function getServices(): array
    {
        // This method would fetch all services available.
        return [];
    }

    /**
     * Retrieves detailed information for a specific service.
     *
     * @param string $serviceId The unique ID or slug of the service.
     * @return object|null An object representing the service details, or null if not found.
     */
    public function getServiceDetails(string $serviceId): ?object
    {
        // This method would fetch detailed information for a single service,
        // including package options, inclusions, etc.
        return null;
    }

    /**
     * Retrieves information about the professional/company (e.g., 'About Us' content).
     *
     * @return object An object containing 'About Us' page content.
     */
    public function getAboutInfo(): object
    {
        // This would typically fetch static content for the 'About' page.
        return (object)['title' => '', 'content' => '', 'image' => ''];
    }

    /**
     * Retrieves a list of client testimonials.
     *
     * @param int $limit Optional number of testimonials to retrieve.
     * @return array An array of testimonial data.
     */
    public function getTestimonials(int $limit = 5): array
    {
        // This would fetch testimonials from a database.
        return [];
    }

    /**
     * Submits a contact form message.
     *
     * @param string $name    Client's name.
     * @param string $email   Client's email address.
     * @param string $subject Subject of the message.
     * @param string $message The actual message content.
     * @return bool True if the message was sent successfully, false otherwise.
     */
    public function submitContactForm(string $name, string $email, string $subject, string $message): bool
    {
        // This method would handle saving the contact message to a database
        // and/or sending an email notification to the admin.
        return false;
    }

    /**
     * Retrieves available time slots for a specific service on a given date range.
     * This is crucial for the booking calendar.
     *
     * @param string      $serviceId The ID of the service being booked.
     * @param string      $startDate  The start date (e.g., 'YYYY-MM-DD').
     * @param string      $endDate    The end date (e.g., 'YYYY-MM-DD').
     * @return array An array of available time slots (e.g., ['2025-07-28 10:00', '2025-07-28 14:00']).
     */
    public function getAvailableTimeSlots(string $serviceId, string $startDate, string $endDate): array
    {
        // This would query the booking system/database to find free slots.
        return [];
    }

    /**
     * Submits a booking request for a service.
     *
     * @param string $serviceId    The ID of the service being booked.
     * @param string $dateTime     The chosen date and time for the booking (e.g., 'YYYY-MM-DD HH:MM').
     * @param string $clientName   Client's full name.
     * @param string $clientEmail  Client's email address.
     * @param string $clientPhone  Client's phone number.
     * @param string $notes        Any additional notes from the client.
     * @return bool True if the booking request was successfully submitted, false otherwise.
     */
    public function submitBookingRequest(
        string $serviceId,
        string $dateTime,
        string $clientName,
        string $clientEmail,
        string $clientPhone,
        string $notes = ''
    ): bool {
        // This method would save the booking request to the database.
        // It might also trigger an email confirmation.
        return false;
    }

    /**
     * Processes a payment for a booking (e.g., deposit or full payment).
     * This would typically integrate with a payment gateway.
     *
     * @param string $bookingId   The ID of the booking associated with the payment.
     * @param float  $amount      The amount to be paid.
     * @param array  $paymentData Data from the payment gateway (e.g., token, card details).
     * @return bool True if the payment was successful, false otherwise.
     */
    public function processPayment(string $bookingId, float $amount, array $paymentData): bool
    {
        // This would interface with a payment gateway API (Stripe, PayPal, etc.).
        return false;
    }

    /**
     * Subscribes a user to a newsletter.
     *
     * @param string $email The email address to subscribe.
     * @return bool True if subscription was successful, false otherwise.
     */
    public function subscribeNewsletter(string $email): bool
    {
        // This would add the email to a mailing list database or service.
        return false;
    }
}