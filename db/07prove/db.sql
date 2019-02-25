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
, day_exercise
, exercise_set
CASCADE;


-- Create tables
CREATE TABLE member
( member_id     SERIAL        PRIMARY KEY
, username      VARCHAR(100)  UNIQUE NOT NULL
-- Using PHP's password_hash() with PASSWORD_BCRYPT
-- will result in a 60 character string
, password_hash VARCHAR(60)   NOT NULL
, email         VARCHAR       NOT NULL
, display_name  VARCHAR       NOT NULL
, is_admin      BOOLEAN       NOT NULL DEFAULT FALSE
, created_at    TIMESTAMP     NOT NULL
);

CREATE TABLE program
( program_id    SERIAL    PRIMARY KEY
, name          VARCHAR   NOT NULL
, created_at    TIMESTAMP NOT NULL
, last_modified TIMESTAMP NOT NULL
, member_id     INTEGER   NOT NULL REFERENCES member(member_id)
);

CREATE TABLE day
( day_id        SERIAL  PRIMARY KEY
, name          VARCHAR NOT NULL
, display_order INTEGER NOT NULL
, program_id    INTEGER NOT NULL REFERENCES program(program_id)
);

CREATE TABLE exercise
( exercise_id SERIAL  PRIMARY KEY
, name        VARCHAR NOT NULL
, description VARCHAR NOT NULL
, member_id   INTEGER NOT NULL REFERENCES member(member_id)
);

CREATE TABLE day_exercise
( day_exercise_id SERIAL  PRIMARY KEY
, display_order   INTEGER NOT NULL
, day_id          INTEGER NOT NULL REFERENCES day(day_id)
, exercise_id     INTEGER NOT NULL REFERENCES exercise(exercise_id)
);

CREATE TABLE exercise_set
( exercise_set_id SERIAL  PRIMARY KEY
, weight          INTEGER NOT NULL
, repetitions     INTEGER NOT NULL
, display_order   INTEGER NOT NULL
, exercise_id     INTEGER NOT NULL REFERENCES exercise(exercise_id)
);


-- Insert data
INSERT INTO member
( username
, password_hash
, email
, display_name
, is_admin
, created_at )
VALUES
( 'admin'                                                         -- username
, '$2y$10$dGewGKbNId.qfuk.wuOVtOXITNa5HoivSKoxqFa9j59P.arj8pq0O'  -- password_hash
, 'admin@example.com'                                             -- email
, 'Administrator'                                                 -- display_name
, TRUE                                                            -- is_admin
, LOCALTIMESTAMP                                                  -- created_at
),
( 'test'                                                          -- username
, '$2y$10$U12XOK0MFQVXAEhFqXSsrud7KXKPPBOmMPtOrcKxhlU115CTb1xki'  -- password_hash
, 'test@example.com'                                              -- email
, 'Test User'                                                     -- display_name
, FALSE                                                           -- is_admin
, LOCALTIMESTAMP                                                  -- created_at
),
( 'other'                                                         -- username
, '$2y$10$LTt3GLk2mln6q/IQ0j4xVO28o/PbRmQYsbOhEpaeiURDhqg0sai96'  -- password_hash
, 'other@example.com'                                             -- email
, 'Other User'                                                    -- display_name
, FALSE                                                           -- is_admin
, LOCALTIMESTAMP                                                  -- created_at
);

INSERT INTO program
( name
, created_at
, last_modified
, member_id )
VALUES
( 'Regular'                   -- name
, LOCALTIMESTAMP              -- created_at
, LOCALTIMESTAMP              -- last_modified
, ( SELECT member_id
    FROM member
    WHERE username = 'test' ) -- member_id
),
( 'Special'                     -- name
, LOCALTIMESTAMP                -- created_at
, LOCALTIMESTAMP                -- last_modified
, ( SELECT member_id
    FROM member
    WHERE username = 'other' )  -- member_id
);

INSERT INTO day
( name
, display_order
, program_id )
VALUES                                            -- BEGIN DAY 1
( 'Chest/Triceps'                                 -- name
, 0                                               -- display_order
, ( SELECT program_id
    FROM program
    WHERE name = 'Regular'
    LIMIT 1 )                                     -- program_id
),                                                -- BEGIN DAY 2
( 'Back/Biceps'                                   -- name
, 1                                               -- display_order
, ( SELECT program_id
    FROM program
    WHERE name = 'Regular'
    LIMIT 1 )                                     -- program_id
),                                                -- BEGIN DAY 3
( 'Shoulders/Abs'                                 -- name
, 2                                               -- display_order
, ( SELECT program_id
    FROM program
    WHERE name = 'Regular'
    LIMIT 1 )                                     -- program_id
),                                                -- BEGIN DAY 4
( 'Legs'                                          -- name
, 3                                               -- display_order
, ( SELECT program_id
    FROM program
    WHERE name = 'Regular'
    LIMIT 1 )                                     -- program_id
);

INSERT INTO exercise
( name
, description
, member_id )
VALUES
( 'Bench Press'                                         -- name
, 'Where you lie down with the big barbell and weights' -- description
, ( SELECT member_id
    FROM member
    WHERE username = 'test' )                           -- member_id
),
( 'Skull Crushers'                                              -- name
, 'Where you lie down and do tricep extensions over your head'  -- description
, ( SELECT member_id
    FROM member
    WHERE username = 'test' )                                   -- member_id
),
( 'Deadlifts'                  -- name
, 'Where you lift dead weight' -- description
, ( SELECT member_id
    FROM member
    WHERE username = 'test' ) -- member_id
),
( 'Curls'                                             -- name
, 'Where you curl your arms up while holding weights' -- description
, ( SELECT member_id
    FROM member
    WHERE username = 'test' )                         -- member_id
),
( 'Military Press'                                    -- name
, 'Where you push weights up from the shoulder level' -- description
, ( SELECT member_id
    FROM member
    WHERE username = 'test' )                         -- member_id
),
( 'Cable Crunches'                                      -- name
, 'Where you kneel and crunch down using a high pulley' -- description
, ( SELECT member_id
    FROM member
    WHERE username = 'test' )                           -- member_id
),
( 'Squats'                                                      -- name
, 'Where you have a barbell over your shoulders and squat down' -- description
, ( SELECT member_id
    FROM member
    WHERE username = 'test' )                                   -- member_id
);

INSERT INTO day_exercise
( display_order
, day_id
, exercise_id )
VALUES
( 0                               -- display_order
, ( SELECT day_id
    FROM day
    WHERE name = 'Chest/Triceps'
    LIMIT 1 )                     -- day_id
, ( SELECT exercise_id
    FROM exercise
    WHERE name = 'Bench Press'
    LIMIT 1 )                     -- exercise_id
),
( 1                               -- display_order
, ( SELECT day_id
    FROM day
    WHERE name = 'Chest/Triceps'
    LIMIT 1 )                     -- day_id
, ( SELECT exercise_id
    FROM exercise
    WHERE name = 'Skull Crushers'
    LIMIT 1 )                     -- exercise_id
),
( 0                             -- display_order
, ( SELECT day_id
    FROM day
    WHERE name = 'Back/Biceps'
    LIMIT 1 )                   -- day_id
, ( SELECT exercise_id
    FROM exercise
    WHERE name = 'Deadlifts'
    LIMIT 1 )                   -- exercise_id
),
( 1                             -- display_order
, ( SELECT day_id
    FROM day
    WHERE name = 'Back/Biceps'
    LIMIT 1 )                   -- day_id
, ( SELECT exercise_id
    FROM exercise
    WHERE name = 'Curls'
    LIMIT 1 )                   -- exercise_id
),
( 0                               -- display_order
, ( SELECT day_id
    FROM day
    WHERE name = 'Shoulders/Abs'
    LIMIT 1 )                     -- day_id
, ( SELECT exercise_id
    FROM exercise
    WHERE name = 'Military Press'
    LIMIT 1 )                     -- exercise_id
),
( 1                               -- display_order
, ( SELECT day_id
    FROM day
    WHERE name = 'Shoulders/Abs'
    LIMIT 1 )                     -- day_id
, ( SELECT exercise_id
    FROM exercise
    WHERE name = 'Cable Crunches'
    LIMIT 1 )                     -- exercise_id
),
( 0                       -- display_order
, ( SELECT day_id
    FROM day
    WHERE name = 'Legs'
    LIMIT 1 )             -- day_id
, ( SELECT exercise_id
    FROM exercise
    WHERE name = 'Squats'
    LIMIT 1 )             -- exercise_id
);

INSERT INTO exercise_set
( weight
, repetitions
, display_order
, exercise_id )
VALUES
( 135                           -- weight
, 10                            -- repetitions
, 0                             -- display_order
, ( SELECT exercise_id
    FROM exercise
    WHERE name = 'Bench Press'
    LIMIT 1 )                   -- exercise_id
),
( 185                           -- weight
, 5                             -- repetitions
, 1                             -- display_order
, ( SELECT exercise_id
    FROM exercise
    WHERE name = 'Bench Press'
    LIMIT 1 )                   -- exercise_id
),
( 205                           -- weight
, 5                             -- repetitions
, 2                             -- display_order
, ( SELECT exercise_id
    FROM exercise
    WHERE name = 'Bench Press'
    LIMIT 1 )                   -- exercise_id
),
( 225                           -- weight
, 5                             -- repetitions
, 3                             -- display_order
, ( SELECT exercise_id
    FROM exercise
    WHERE name = 'Bench Press'
    LIMIT 1 )                   -- exercise_id
),
( 45                              -- weight
, 10                              -- repetitions
, 0                               -- display_order
, ( SELECT exercise_id
    FROM exercise
    WHERE name = 'Skull Crushers'
    LIMIT 1 )                     -- exercise_id
),
( 55                              -- weight
, 5                               -- repetitions
, 1                               -- display_order
, ( SELECT exercise_id
    FROM exercise
    WHERE name = 'Skull Crushers'
    LIMIT 1 )                     -- exercise_id
),
( 65                              -- weight
, 5                               -- repetitions
, 2                               -- display_order
, ( SELECT exercise_id
    FROM exercise
    WHERE name = 'Skull Crushers'
    LIMIT 1 )                     -- exercise_id
),
( 75                              -- weight
, 5                               -- repetitions
, 3                               -- display_order
, ( SELECT exercise_id
    FROM exercise
    WHERE name = 'Skull Crushers'
    LIMIT 1 )                     -- exercise_id
),
( 115                       -- weight
, 10                        -- repetitions
, 0                         -- display_order
, ( SELECT exercise_id
    FROM exercise
    WHERE name = 'Deadlifts'
    LIMIT 1 )               -- exercise_id
),
( 135                       -- weight
, 5                         -- repetitions
, 1                         -- display_order
, ( SELECT exercise_id
    FROM exercise
    WHERE name = 'Deadlifts'
    LIMIT 1 )               -- exercise_id
),
( 145                       -- weight
, 5                         -- repetitions
, 2                         -- display_order
, ( SELECT exercise_id
    FROM exercise
    WHERE name = 'Deadlifts'
    LIMIT 1 )               -- exercise_id
),
( 155                       -- weight
, 5                         -- repetitions
, 3                         -- display_order
, ( SELECT exercise_id
    FROM exercise
    WHERE name = 'Deadlifts'
    LIMIT 1 )               -- exercise_id
),
( 25                      -- weight
, 10                      -- repetitions
, 0                       -- display_order
, ( SELECT exercise_id
    FROM exercise
    WHERE name = 'Curls'
    LIMIT 1 )             -- exercise_id
),
( 30                      -- weight
, 5                       -- repetitions
, 1                       -- display_order
, ( SELECT exercise_id
    FROM exercise
    WHERE name = 'Curls'
    LIMIT 1 )             -- exercise_id
),
( 35                      -- weight
, 5                       -- repetitions
, 2                       -- display_order
, ( SELECT exercise_id
    FROM exercise
    WHERE name = 'Curls'
    LIMIT 1 )             -- exercise_id
),
( 40                      -- weight
, 5                       -- repetitions
, 3                       -- display_order
, ( SELECT exercise_id
    FROM exercise
    WHERE name = 'Curls'
    LIMIT 1 )             -- exercise_id
),
( 55                              -- weight
, 10                              -- repetitions
, 0                               -- display_order
, ( SELECT exercise_id
    FROM exercise
    WHERE name = 'Military Press'
    LIMIT 1 )                     -- exercise_id
),
( 60                              -- weight
, 5                               -- repetitions
, 1                               -- display_order
, ( SELECT exercise_id
    FROM exercise
    WHERE name = 'Military Press'
    LIMIT 1 )                     -- exercise_id
),
( 65                              -- weight
, 5                               -- repetitions
, 2                               -- display_order
, ( SELECT exercise_id
    FROM exercise
    WHERE name = 'Military Press'
    LIMIT 1 )                     -- exercise_id
),
( 70                              -- weight
, 5                               -- repetitions
, 3                               -- display_order
, ( SELECT exercise_id
    FROM exercise
    WHERE name = 'Military Press'
    LIMIT 1 )                     -- exercise_id
),
( 60                              -- weight
, 10                              -- repetitions
, 0                               -- display_order
, ( SELECT exercise_id
    FROM exercise
    WHERE name = 'Cable Crunches'
    LIMIT 1 )                     -- exercise_id
),
( 70                              -- weight
, 10                              -- repetitions
, 1                               -- display_order
, ( SELECT exercise_id
    FROM exercise
    WHERE name = 'Cable Crunches'
    LIMIT 1 )                     -- exercise_id
),
( 80                              -- weight
, 10                              -- repetitions
, 2                               -- display_order
, ( SELECT exercise_id
    FROM exercise
    WHERE name = 'Cable Crunches'
    LIMIT 1 )                     -- exercise_id
),
( 90                              -- weight
, 10                              -- repetitions
, 3                               -- display_order
, ( SELECT exercise_id
    FROM exercise
    WHERE name = 'Cable Crunches'
    LIMIT 1 )                     -- exercise_id
),
( 135                     -- weight
, 10                      -- repetitions
, 0                       -- display_order
, ( SELECT exercise_id
    FROM exercise
    WHERE name = 'Squats'
    LIMIT 1 )             -- exercise_id
),
( 185                     -- weight
, 5                       -- repetitions
, 1                       -- display_order
, ( SELECT exercise_id
    FROM exercise
    WHERE name = 'Squats'
    LIMIT 1 )             -- exercise_id
),
( 205                     -- weight
, 5                       -- repetitions
, 2                       -- display_order
, ( SELECT exercise_id
    FROM exercise
    WHERE name = 'Squats'
    LIMIT 1 )             -- exercise_id
),
( 225                     -- weight
, 5                       -- repetitions
, 3                       -- display_order
, ( SELECT exercise_id
    FROM exercise
    WHERE name = 'Squats'
    LIMIT 1 )             -- exercise_id
);


-- Display data
SELECT * FROM member;
SELECT  p.program_id
,       p.name
,       p.created_at
,       p.last_modified
,       m.member_id
,       m.username
FROM  program p INNER JOIN
      member m USING (member_id);
SELECT  d.day_id
,       d.name AS day_name
,       d.display_order
,       p.program_id
,       p.name AS program_name
FROM  day d INNER JOIN
      program p USING (program_id);
SELECT  e.exercise_id
,       e.name
,       e.description
,       m.member_id
,       m.username
FROM  exercise e INNER JOIN
      member m USING (member_id);
SELECT  de.day_exercise_id
,       de.display_order
,       d.day_id
,       d.name AS day_name
,       e.exercise_id
,       e.name AS exercise_name
FROM  day_exercise de INNER JOIN
      day d USING (day_id) INNER JOIN
      exercise e USING (exercise_id);
SELECT  es.exercise_set_id
,       es.weight
,       es.repetitions
,       es.display_order
,       e.exercise_id
,       e.name AS exercise_name
FROM  exercise_set es INNER JOIN
      exercise e USING (exercise_id);
SELECT  es.exercise_set_id
,       e.exercise_id
,       de.day_exercise_id
,       d.day_id
,       p.program_id
,       m.member_id
FROM  exercise_set es INNER JOIN
      exercise e USING (exercise_id) INNER JOIN
      day_exercise de USING (exercise_id) INNER JOIN
      day d USING (day_id) INNER JOIN
      program p USING (program_id) INNER JOIN
      member m ON p.member_id = m.member_id
WHERE m.member_id = ( SELECT member_id
                      FROM member
                      WHERE username = 'test' );
