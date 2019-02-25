DROP TABLE IF EXISTS member_teach_07 CASCADE;

CREATE TABLE member_teach_07
( member_id     SERIAL  PRIMARY KEY
, username      VARCHAR NOT NULL UNIQUE
, password_hash VARCHAR NOT NULL
);
