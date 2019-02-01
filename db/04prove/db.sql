-- Helpful commands:
--  \dt               - Lists the tables
--  \d+ public.user   - Shows the details of the user table
--  \i file.sql       - Imports and runs file.sql
--  \q                - Quit the application and go back to the regular command prompt

-- Get rid of tables and their dependents so we can create them
DROP TABLE IF EXISTS
  member
, program
, day
, exercise
, day_exercises
, exercise_set
CASCADE;


-- Create tables
CREATE TABLE member
( member_id     INTEGER       PRIMARY KEY
, username      VARCHAR(100)  UNIQUE NOT NULL
-- Using PHP's password_hash() with PASSWORD_BCRYPT
-- will result in a 60 character string
, password_hash VARCHAR(60)   NOT NULL
, email         VARCHAR       NOT NULL
, display_name  VARCHAR       NOT NULL
, created_on    TIMESTAMP     NOT NULL
);

CREATE TABLE program
( program_id    INTEGER   PRIMARY KEY
, name          VARCHAR   NOT NULL
, created       TIMESTAMP NOT NULL
, last_modified TIMESTAMP NOT NULL
, member_id     INTEGER   NOT NULL REFERENCES member(member_id)
);

CREATE TABLE day
( day_id        INTEGER PRIMARY KEY
, name          VARCHAR NOT NULL
, display_order INTEGER NOT NULL
, program_id    INTEGER NOT NULL REFERENCES program(program_id)
);

CREATE TABLE exercise
( exercise_id INTEGER PRIMARY KEY
, name        VARCHAR NOT NULL
, description VARCHAR NOT NULL
, member_id   INTEGER NOT NULL REFERENCES member(member_id)
);

CREATE TABLE day_exercises
( day_exercises_id  INTEGER PRIMARY KEY
, display_order     INTEGER NOT NULL
, day_id            INTEGER NOT NULL REFERENCES day(day_id)
, exercise_id       INTEGER NOT NULL REFERENCES exercise(exercise_id)
);

CREATE TABLE exercise_set
( exercise_set_id INTEGER PRIMARY KEY
, weight          INTEGER NOT NULL
, repetitions     INTEGER NOT NULL
, display_order   INTEGER NOT NULL
, exercise_id     INTEGER NOT NULL REFERENCES exercise(exercise_id)
);
