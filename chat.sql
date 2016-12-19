/*----------------------------------------
 * CREATE DATABASE
 *----------------------------------------*/
CREATE DATABASE chat_db;
USE chat_db;

/*-- CREATE TABLE --*/

CREATE TABLE user_info(
    id             int,
    loginid        varchar(32)  NOT NULL,
    password       varchar(16),
    dispname       varchar(32),
    del_flag       boolean,
    lastlogin_date datetime,

    PRIMARY KEY(id)
);

/**
 * Tweets Table
 */
CREATE TABLE chat_log(
    id            int            NOT NULL AUTO_INCREMENT,
    user_id       varchar(32)    NOT NULL,
    text          varchar(255)   NOT NULL,
    date          datetime,

    PRIMARY KEY(id)
);

/*----------------------------------------
 * INSERT
 *----------------------------------------*/
/**
 * User
 */
INSERT INTO user_info(id, loginid, password, dispname, del_flag, lastlogin_date)
VALUES (1, 'tom',      'nosushinolife', 'GOD',  false, '2016-12-19 10:00:00'),
       (2, 'mike',     'apple2016',     'Taro', false, '2016-12-19 10:05:00'),
       (3, 'mary',     'c@ndyclash',    'Yoko', false, '2016-12-19 10:10:00');

