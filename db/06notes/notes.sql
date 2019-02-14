-- Get rid of existing tables
DROP TABLE IF EXISTS
  course
, note
CASCADE;


-- Create tables
CREATE TABLE course
( course_id   SERIAL      PRIMARY KEY
, name        VARCHAR(60) NOT NULL
, course_code VARCHAR(10) NOT NULL
);

CREATE TABLE note
( note_id   SERIAL  PRIMARY KEY
, date      DATE    NOT NULL
, content   TEXT    NOT NULL
, course_id INT     NOT NULL REFERENCES course(course_id)
);


-- Insert data
INSERT INTO course
( name
, course_code )
VALUES
( 'Web II'
, 'CS 313'
);
INSERT INTO course
( name
, course_code )
VALUES
( 'Web I'
, 'CS 213'
);
