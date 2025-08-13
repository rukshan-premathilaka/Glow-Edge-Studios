<?php

namespace controller;

use core\DBHandle;

class Booking extends Helper
{

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }


    public function add(): string
    {
        $user_id = $_SESSION['user']['user_id'];
        $service_id = $this->PostInput('service');
        $message = $this->PostInput('message');

        $result = DBHandle::query("INSERT INTO bookings (user_user_id, services_services_id, client_message) VALUES (:user_id, :service_id, :message)", [
            'user_id' => $user_id,
            'service_id' => $service_id,
            'message' => $message
        ]);

        if (!$result) {
            return $this->jsonResponse("error", "Database error!", 500);
        }

        return $this->jsonResponse("success", "Booking added!");
    }

    public function getCountTotal(): string
    {
        $data = DBHandle::query('SELECT COUNT(*) as total_bookings FROM bookings');
        return (string) $data[0]['total_bookings'];
    }

    public function getCountPending(): string
    {
        $data = DBHandle::query("SELECT COUNT(*) as total_bookings FROM bookings where status = 'pending'");
        return (string) $data[0]['total_bookings'];
    }

    public function getRecent(): array
    {
        $quarry = '
                    SELECT
                        b.user_user_id,
                        b.services_services_id,
                        b.client_message,
                        b.created_at,
                        b.status,
                        s.title service_title,
                        s.price service_price,
                        u.name user_name,
                        u.email user_email
                    FROM
                        bookings b
                            INNER JOIN
                        services s ON b.services_services_id = s.services_id
                            INNER JOIN
                        user u ON b.user_user_id = u.user_id
                    ORDER BY
                        b.created_at
                    LIMIT 20;
                  ';

        return DBHandle::query($quarry);
    }



}