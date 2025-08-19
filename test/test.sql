# GET ALL USERS
SELECT
    u.user_id,
    u.name,
    r.role
FROM
    user u
        INNER JOIN user_has_role uhr ON u.user_id = uhr.user_user_id
        INNER JOIN role r ON uhr.role_role_id = r.role_id
WHERE u.user_id = 30;

# INSERT ROLE
INSERT INTO user_has_role (user_user_id, role_role_id) VALUES (30, 1);

# GET ALL ROLES
SELECT
    r.role
FROM
    user_has_role uhr
    INNER JOIN role r ON uhr.role_role_id = r.role_id
    INNER JOIN user u ON uhr.user_user_id = u.user_id
WHERE u.user_id = 30;

# GET ALL PORTFOLIOS
SELECT * FROM portfolio;

# Service
SELECT * FROM services;

SELECT COUNT(*) as services_count FROM services;

# Booking
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
    b.created_at;

SELECT COUNT(*) as booking_count FROM bookings;

# get all user data

SELECT
    user_id,
    name,
    email,
    phone,
    address,
    whatsapp,
    profile_pic
FROM
    user
where user_id = :user_id;

# update user data

UPDATE
    user
SET
    profile_pic = null
WHERE
    user_id = 30;


SELECT
    user.user_id, user.name, role.role
FROM user
    INNER JOIN user_has_role ON user.user_id = user_has_role.user_user_id
    INNER JOIN role  ON user_has_role.role_role_id = role.role_id
WHERE user.user_id = :user_id AND role.role = 'admin';



# get all bookings

SELECT *
FROM bookings b
    INNER JOIN services s ON b.services_services_id = s.services_id
    INNER JOIN user u ON b.user_user_id = u.user_id
WHERE booking_id = :id;

SELECT *
FROM bookings
WHERE booking_id = :id;


SELECT *
FROM bookings
    INNER JOIN services s ON bookings.services_services_id = s.services_id
    INNER JOIN user u ON bookings.user_user_id = u.user_id
LIMIT :limit OFFSET :offset;