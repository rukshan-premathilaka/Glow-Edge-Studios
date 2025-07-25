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