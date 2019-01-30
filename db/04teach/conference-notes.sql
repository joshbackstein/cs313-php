-- Get rid of tables and their dependents so we can create them
DROP TABLE IF EXISTS
  note
, talk
, conference
, session_name
, speaker
, member
CASCADE;


-- Create tables
CREATE TABLE conference
( conference_id INTEGER PRIMARY KEY
, year          INTEGER NOT NULL
, month         INTEGER NOT NULL
);

CREATE TABLE session_name
( session_name_id INTEGER PRIMARY KEY
, name            VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE speaker
( speaker_id  INTEGER PRIMARY KEY
, first_name  VARCHAR(100) NOT NULL
, middle_name VARCHAR(100)
, last_name   VARCHAR(100) NOT NULL
);

CREATE TABLE talk
( talk_id         INTEGER PRIMARY KEY
, title           VARCHAR(500) NOT NULL
, conference_id   INTEGER NOT NULL REFERENCES conference(conference_id)
, session_name_id INTEGER NOT NULL REFERENCES session_name(session_name_id)
, speaker_id      INTEGER NOT NULL REFERENCES speaker(speaker_id)
);

CREATE TABLE member
( member_id INTEGER PRIMARY KEY
, username  VARCHAR(100) NOT NULL UNIQUE
, password  VARCHAR(100) NOT NULL
);

CREATE TABLE note
( note_id   INTEGER PRIMARY KEY
, contents  VARCHAR(500) NOT NULL
, member_id INTEGER NOT NULL REFERENCES member(member_id)
, talk_id   INTEGER NOT NULL REFERENCES talk(talk_id)
);


-- Create sequences
-- They will be owned by specific table columns, which should
-- cause the sequences to be dropped when the table owning
-- them is dropped
CREATE SEQUENCE conference_s1
  OWNED BY conference.conference_id;
CREATE SEQUENCE session_name_s1
  OWNED BY session_name.session_name_id;
CREATE SEQUENCE speaker_s1
  OWNED BY speaker.speaker_id;
CREATE SEQUENCE talk_s1
  OWNED BY talk.talk_id;
CREATE SEQUENCE member_s1
  OWNED BY member.member_id;
CREATE SEQUENCE note_s1
  OWNED BY note.note_id;


-- Create data for session names
INSERT INTO session_name
( session_name_id
, name )
VALUES
( nextval('session_name_s1')  -- session_name_id
, 'Saturday morning'          -- name
);
INSERT INTO session_name
( session_name_id
, name )
VALUES
( nextval('session_name_s1')  -- session_name_id
, 'Saturday afternoon'        -- name
);
INSERT INTO session_name
( session_name_id
, name )
VALUES
( nextval('session_name_s1')  -- session_name_id
, 'General Womens'            -- name
);
INSERT INTO session_name
( session_name_id
, name )
VALUES
( nextval('session_name_s1')  -- session_name_id
, 'Sunday morning'            -- name
);
INSERT INTO session_name
( session_name_id
, name )
VALUES
( nextval('session_name_s1')  -- session_name_id
, 'Sunday afternoon'          -- name
);


-- Insert data for last conference
INSERT INTO conference
( conference_id
, year
, month )
VALUES
( nextval('conference_s1')  -- conference_id
, 2018                      -- year
, 10                        -- month
);


-- Insert data for speakers
INSERT INTO speaker
( speaker_id
, first_name
, middle_name
, last_name )
VALUES
( nextval('speaker_s1')   -- speaker_id
, 'M.'                    -- first_name
, 'Joseph'                -- middle_name
, 'Brough'                -- last_name
);
INSERT INTO speaker
( speaker_id
, first_name
, middle_name
, last_name )
VALUES
( nextval('speaker_s1')   -- speaker_id
, 'Russell'               -- first_name
, 'M.'                    -- middle_name
, 'Nelson'                -- last_name
);


-- Insert data for talks
INSERT INTO talk
( talk_id
, title
, conference_id
, session_name_id
, speaker_id )
VALUES
( nextval('talk_s1')                  -- talk_id
, 'Lift Up Your Head and Rejoice'     -- title
, currval('conference_s1')            -- conference_id
, ( SELECT session_name_id
    FROM session_name
    WHERE name = 'Saturday morning' ) -- session_name_id
, ( SELECT speaker_id
    FROM speaker
    WHERE first_name = 'M.'
      AND middle_name = 'Joseph'
      AND last_name = 'Brough' )      -- speaker_id
);
INSERT INTO talk
( talk_id
, title
, conference_id
, session_name_id
, speaker_id )
VALUES
( nextval('talk_s1')                                  -- talk_id
, 'Sisters Participation in the Gathering of Israel'  -- title
, currval('conference_s1')                            -- conference_id
, ( SELECT session_name_id
    FROM session_name
    WHERE name = 'General Womens' )                   -- session_name_id
, ( SELECT speaker_id
    FROM speaker
    WHERE first_name = 'Russell'
      AND middle_name = 'M.'
      AND last_name = 'Nelson' )                      -- speaker_id
);
INSERT INTO talk
( talk_id
, title
, conference_id
, session_name_id
, speaker_id )
VALUES
( nextval('talk_s1')                -- talk_id
, 'The Correct Name of the Church'  -- title
, currval('conference_s1')          -- conference_id
, ( SELECT session_name_id
    FROM session_name
    WHERE name = 'Sunday morning' ) -- session_name_id
, ( SELECT speaker_id
    FROM speaker
    WHERE first_name = 'Russell'
      AND middle_name = 'M.'
      AND last_name = 'Nelson' )    -- speaker_id
);


-- Create member
INSERT INTO member
( member_id
, username
, password )
VALUES
( nextval('member_s1')  -- member_id
, 'jb'                  -- username
, 'pw'                  -- password
);


-- Create notes
INSERT INTO note
( note_id
, contents
, member_id
, talk_id )
VALUES
( nextval('note_s1')                                  -- note_id
, 'I feel inspired to lift up my head and rejoice.'   -- contents
, currval('member_s1')                                -- member_id
, ( SELECT talk_id
    FROM talk
    WHERE title = 'Lift Up Your Head and Rejoice' )   -- talk_id
);
INSERT INTO note
( note_id
, contents
, member_id
, talk_id )
VALUES
( nextval('note_s1')                                  -- note_id
, 'Super cool talk!'                                  -- contents
, currval('member_s1')                                -- member_id
, ( SELECT talk_id
    FROM talk
    WHERE title = 'Lift Up Your Head and Rejoice' )   -- talk_id
);
INSERT INTO note
( note_id
, contents
, member_id
, talk_id )
VALUES
( nextval('note_s1')                                                    -- note_id
, 'This is so cool!'                                                    -- contents
, currval('member_s1')                                                  -- member_id
, ( SELECT talk_id
    FROM talk
    WHERE title = 'Sisters Participation in the Gathering of Israel' )  -- talk_id
);
INSERT INTO note
( note_id
, contents
, member_id
, talk_id )
VALUES
( nextval('note_s1')                                                    -- note_id
, 'Time for the gathering!'                                             -- contents
, currval('member_s1')                                                  -- member_id
, ( SELECT talk_id
    FROM talk
    WHERE title = 'Sisters Participation in the Gathering of Israel' )  -- talk_id
);
INSERT INTO note
( note_id
, contents
, member_id
, talk_id )
VALUES
( nextval('note_s1')                                  -- note_id
, 'Oops!'                                             -- contents
, currval('member_s1')                                -- member_id
, ( SELECT talk_id
    FROM talk
    WHERE title = 'The Correct Name of the Church' )  -- talk_id
);
INSERT INTO note
( note_id
, contents
, member_id
, talk_id )
VALUES
( nextval('note_s1')                                  -- note_id
, 'Time to change!'                                   -- contents
, currval('member_s1')                                -- member_id
, ( SELECT talk_id
    FROM talk
    WHERE title = 'The Correct Name of the Church' )  -- talk_id
);


-- Query notes about a particular talk
SELECT *
FROM note
WHERE talk_id = ( SELECT talk_id
                  FROM talk
                  WHERE title = 'The Correct Name of the Church' );
