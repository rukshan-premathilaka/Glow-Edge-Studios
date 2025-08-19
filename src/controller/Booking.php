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
    public function getAllByUser(): array
    {
        $quarry = '
            SELECT *
            FROM bookings b
                INNER JOIN services s ON b.services_services_id = s.services_id
                INNER JOIN user u ON b.user_user_id = u.user_id
            WHERE user_user_id = :userId;
        ';

        $params = [
            'userId' => $_SESSION['user']['user_id']
        ];

        return DBHandle::query($quarry, $params);
    }
    public function getDetails() : array
    {
        $id = $this->GetInput('id');
        $quarry = 'SELECT *
                FROM bookings b
                    INNER JOIN services s ON b.services_services_id = s.services_id
                    INNER JOIN user u ON b.user_user_id = u.user_id
                WHERE booking_id = :id;';
        $data = DBHandle::query($quarry, ['id' => $id]);

        return $data[0];
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
    public function getAll(): string
    {
        $offset = $this->PostInput('offset');
        $limit = $this->PostInput('limit');
        $status = $this->PostInput('status');

        $params = [
            'limit' => (int)$limit,
            'offset' => (int)$offset
        ];

        if ($status === 'all') {
            $query = ' SELECT *
                   FROM bookings
                       INNER JOIN services s ON bookings.services_services_id = s.services_id
                       INNER JOIN user u ON bookings.user_user_id = u.user_id
                   LIMIT :limit OFFSET :offset;';
        } else {
            $query = ' SELECT *
                   FROM bookings
                       INNER JOIN services s ON bookings.services_services_id = s.services_id
                       INNER JOIN user u ON bookings.user_user_id = u.user_id
                   WHERE status = :status
                   LIMIT :limit OFFSET :offset;';
            $params['status'] = $status;
        }

        $data = DBHandle::query(
            $query,
            $params
        );

        return $this->jsonResponse( 'success', 'Data Loaded!', 200, $data);
    }
    public function getAllView(): array
    {
        $query = ' SELECT *
                    FROM bookings
                        INNER JOIN services s ON bookings.services_services_id = s.services_id
                        INNER JOIN user u ON bookings.user_user_id = u.user_id
                    LIMIT :limit OFFSET :offset;';

        $data = DBHandle::query(
            $query,
            [
                'limit' => 10,
                'offset' => 0
            ]
        );

        return $data;
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