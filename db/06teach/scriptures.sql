DROP TABLE IF EXISTS
  scriptures
, topics
, scriptures_topics
CASCADE;

CREATE TABLE scriptures
( id          SERIAL      PRIMARY KEY
, book        VARCHAR(50) NOT NULL
, book_lower  VARCHAR(50) NOT NULL
, chapter     SMALLINT    NOT NULL
, verse       SMALLINT    NOT NULL
, content     VARCHAR     NOT NULL
);

INSERT INTO scriptures
( book
, book_lower
, chapter
, verse
, content
)
VALUES
( 'John'
, 'john'
, 1
, 5
, 'And the light shineth in darkness; and the darkness comprehended it not.'
),
( 'Doctrine and Covenants'
, 'doctrine and covenants'
, 88
, 49
, 'The light shineth in darkness, and the darkness comprehendeth it not;'
    ' nevertheless, the day shall come when you shall comprehend even God,'
    ' being quickened in him and by him.'
),
( 'Doctrine and Covenants'
, 'doctrine and covenants'
, 93
, 28
, 'He that keepeth his commandments receiveth truth and light, until he is'
    ' glorified in truth and knoweth all things.'
),
( 'Mosiah'
, 'mosiah'
, 16
, 9
, 'He is the light and the life of the world; yea, a light that is endless,'
    ' that can never be darkened; yea, and also a life which is endless,'
    ' that there can be no more death.'
);

CREATE TABLE topics
( topic_id SERIAL PRIMARY KEY
, name VARCHAR NOT NULL
);

CREATE TABLE scriptures_topics
( scriptures_topics_id SERIAL PRIMARY KEY
, scriptures_id INT NOT NULL REFERENCES scriptures(id)
, topic_id INT NOT NULL REFERENCES topics(topic_id)
);

INSERT INTO topics (name) VALUES ('Faith'), ('Sacrifice'), ('Charity');
