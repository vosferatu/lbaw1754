DROP SCHEMA IF EXISTS public CASCADE;
CREATE SCHEMA public;

DROP TABLE IF EXISTS content_report CASCADE;
DROP TABLE IF EXISTS downvotes CASCADE;
DROP TABLE IF EXISTS upvotes CASCADE;
DROP TABLE IF EXISTS saves CASCADE;
DROP TABLE IF EXISTS verified CASCADE;
DROP TABLE IF EXISTS inactive CASCADE;
DROP TABLE IF EXISTS suspended CASCADE;
DROP TABLE IF EXISTS banned CASCADE;
DROP TABLE IF EXISTS kicked CASCADE;
DROP TABLE IF EXISTS moderator CASCADE;
DROP TABLE IF EXISTS administrator CASCADE;
DROP TABLE IF EXISTS user_subscribes CASCADE;
DROP TABLE IF EXISTS user_report CASCADE;
DROP TABLE IF EXISTS tags_blocked CASCADE;
DROP TABLE IF EXISTS tags_subscribed CASCADE;
DROP TABLE IF EXISTS comment CASCADE;
DROP TABLE IF EXISTS news_creation CASCADE;
DROP TABLE IF EXISTS news_post CASCADE;
DROP TABLE IF EXISTS content CASCADE;
DROP TABLE IF EXISTS tags CASCADE;
DROP TABLE IF EXISTS users CASCADE;

DROP FUNCTION IF EXISTS news_post_upvote();
DROP FUNCTION IF EXISTS news_post_downvote();
DROP FUNCTION IF EXISTS check_if_news_is_published() CASCADE;
DROP FUNCTION IF EXISTS set_user_published() CASCADE;
DROP FUNCTION IF EXISTS set_news_publish_date() CASCADE;
DROP FUNCTION IF EXISTS check_unique_values_user_f();
DROP FUNCTION IF EXISTS check_unique_value_tags_f();

CREATE TABLE password_resets (
  email VARCHAR NOT NULL,
  token VARCHAR NOT NULL,
  created_at timestamp NOT NULL
);

CREATE TABLE users (
   id SERIAL NOT NULL,
   username text NOT NULL,
   password text NOT NULL,
   email text NOT NULL,
   name text,
   country text,
   introduction text,
   photo text,
   followers INTEGER,
   remember_token VARCHAR,
   registered TIMESTAMP WITH TIME zone DEFAULT now() NOT NULL,
   CONSTRAINT followers_positive CHECK ((followers >= 0))
);

CREATE TABLE tags (
   id SERIAL NOT NULL,
   name text NOT NULL,
   frequency Integer,
   CONSTRAINT frequency_positive CHECK ((frequency >= 0))
);

CREATE TABLE tags_post (
    id SERIAL NOT NULL,
   id_tag Integer NOT NULL,
   id_post Integer NOT NULL
);

CREATE TABLE tags_subscribed (
   id_tag Integer NOT NULL,
   id_user Integer NOT NULL
);

CREATE TABLE tags_blocked (
   id_tag Integer NOT NULL,
   id_user Integer NOT NULL
);

CREATE TABLE user_report (
   id_reported Integer NOT NULL,
   id_informer Integer NOT NULL,
   reason text
);

CREATE TABLE user_subscribes (
   id_followed Integer NOT NULL,
   id_follower Integer NOT NULL
);

CREATE TABLE administrator (
   id Integer NOT NULL,
   started TIMESTAMP WITH TIME zone DEFAULT now() NOT NULL
);

CREATE TABLE moderator (
   id Integer NOT NULL,
   started TIMESTAMP WITH TIME zone DEFAULT now() NOT NULL
);

CREATE TABLE kicked (
   id Integer NOT NULL,
   ban_date TIMESTAMP WITH TIME zone DEFAULT now() NOT NULL,
   reason text
);

CREATE TABLE banned (
   id Integer NOT NULL
);

CREATE TABLE suspended (
   id Integer NOT NULL,
   days Integer NOT NULL,
   CONSTRAINT days_positive CHECK ((days > 0))
);

CREATE TABLE inactive (
   id Integer NOT NULL,
   deletion_date TIMESTAMP WITH TIME zone DEFAULT now() NOT NULL
);

CREATE TABLE verified (
   id Integer NOT NULL,
   status text NOT NULL,
   verified TIMESTAMP WITH TIME zone,
   CONSTRAINT status_enum CHECK ((status = ANY (ARRAY['Verified'::text, 'Pending'::text, 'Unconfirmed'::text]))),
   CONSTRAINT verified_date CHECK ((verified > now()))
);


CREATE TABLE saves (
  id SERIAL NOT NULL,
   id_content Integer NOT NULL,
   id_user Integer NOT NULL
);

CREATE TABLE upvotes (
    id SERIAL NOT NULL,
   id_content Integer NOT NULL,
   id_user Integer NOT NULL
);

CREATE TABLE downvotes (
    id SERIAL NOT NULL,
   id_content Integer NOT NULL,
   id_user Integer NOT NULL
);

CREATE TABLE content_report (
   id SERIAL NOT NULL,
   id_content Integer NOT NULL,
   id_user Integer NOT NULL,
   reason text,
   "date" TIMESTAMP WITH TIME zone DEFAULT now()
);

CREATE TABLE content (
   id SERIAL NOT NULL,
   votes Integer DEFAULT 1,
   "text" Text NOT NULL,
   created TIMESTAMP WITH TIME zone DEFAULT now()
);

CREATE TABLE news_post (
   id Integer NOT NULL,
   title text,
   "description" text,
   slug text,
   comments_count Integer,
   views Integer,
   authors Integer,
   published BOOLEAN NOT NULL,
   published_date TIMESTAMP WITH TIME zone,
   CONSTRAINT views_positive CHECK ((views >= 0)),
   CONSTRAINT comments_positive CHECK ((comments_count >= 0))
);

CREATE TABLE "comment" (
   id Integer NOT NULL,
   user_id Integer NOT NULL,
   parent_comment  Integer,
   parent_news  Integer NOT NULL
);


CREATE TABLE news_creation (
   id_news Integer NOT NULL,
   id_user Integer NOT NULL,
   ready BOOLEAN NOT NULL,
   approval_date TIMESTAMP WITH TIME zone,
   CONSTRAINT approval_date_positive CHECK ((approval_date >= now()))
);


--Primary_Keys_and_Uniques

ALTER TABLE ONLY users
   ADD CONSTRAINT user_pkey PRIMARY KEY (id);

ALTER TABLE ONLY users
   ADD CONSTRAINT user_ukey_username UNIQUE (username);

ALTER TABLE ONLY users
   ADD CONSTRAINT user_ukey_password UNIQUE (password);

ALTER TABLE ONLY users
   ADD CONSTRAINT user_ukey_email UNIQUE (email);

ALTER TABLE ONLY tags
   ADD CONSTRAINT tags_pkey PRIMARY KEY (id);

ALTER TABLE ONLY tags
   ADD CONSTRAINT tags_ukey_name UNIQUE (name);

   ALTER TABLE ONLY tags_post
   ADD CONSTRAINT tags_post_pkey PRIMARY KEY (id);

ALTER TABLE ONLY tags_subscribed
   ADD CONSTRAINT tags_subscribed_pkey PRIMARY KEY (id_tag, id_user);

ALTER TABLE ONLY tags_blocked
   ADD CONSTRAINT tags_blocked_pkey PRIMARY KEY (id_tag, id_user);

ALTER TABLE ONLY user_report
   ADD CONSTRAINT user_report_pkey PRIMARY KEY (id_reported, id_informer);

ALTER TABLE ONLY user_subscribes
   ADD CONSTRAINT user_subscribes_pkey PRIMARY KEY (id_followed, id_follower);

ALTER TABLE ONLY administrator
   ADD CONSTRAINT administrator_pkey PRIMARY KEY (id);

ALTER TABLE ONLY moderator
   ADD CONSTRAINT moderator_pkey PRIMARY KEY (id);

ALTER TABLE ONLY kicked
   ADD CONSTRAINT kicked_pkey PRIMARY KEY (id);

ALTER TABLE ONLY banned
   ADD CONSTRAINT banned_pkey PRIMARY KEY (id);

ALTER TABLE ONLY suspended
   ADD CONSTRAINT suspended_pkey PRIMARY KEY (id);

ALTER TABLE ONLY inactive
   ADD CONSTRAINT inactive_pkey PRIMARY KEY (id);

ALTER TABLE ONLY verified
   ADD CONSTRAINT verified_pkey PRIMARY KEY (id);

ALTER TABLE ONLY content
   ADD CONSTRAINT content_pkey PRIMARY KEY (id);

ALTER TABLE ONLY saves
   ADD CONSTRAINT saves_pkey PRIMARY KEY (id);

ALTER TABLE ONLY upvotes
   ADD CONSTRAINT upvotes_pkey PRIMARY KEY (id);

ALTER TABLE ONLY downvotes
   ADD CONSTRAINT downvotes_pkey PRIMARY KEY (id);

ALTER TABLE ONLY content_report
   ADD CONSTRAINT content_report_pkey PRIMARY KEY (id);

ALTER TABLE ONLY news_post
   ADD CONSTRAINT news_post_pkey PRIMARY KEY (id);

ALTER TABLE ONLY "comment"
   ADD CONSTRAINT comment_pkey PRIMARY KEY (id);


ALTER TABLE ONLY news_creation
   ADD CONSTRAINT news_creation_pkey PRIMARY KEY (id_news, id_user);

--Foreign_Keys

ALTER TABLE ONLY tags_subscribed
   ADD CONSTRAINT tags_subscribed_tags_fkey FOREIGN KEY (id_tag) REFERENCES tags(id) ON UPDATE CASCADE;

ALTER TABLE ONLY tags_subscribed
   ADD CONSTRAINT tags_subscribed_user_fkey FOREIGN KEY (id_user) REFERENCES users(id) ON UPDATE CASCADE;

ALTER TABLE ONLY tags_blocked
   ADD CONSTRAINT tags_blocked_tags_fkey FOREIGN KEY (id_tag) REFERENCES tags(id) ON UPDATE CASCADE;

ALTER TABLE ONLY tags_blocked
   ADD CONSTRAINT tags_blocked_user_fkey FOREIGN KEY (id_user) REFERENCES users(id) ON UPDATE CASCADE;

ALTER TABLE ONLY user_report
   ADD CONSTRAINT user_report_reported_fkey FOREIGN KEY (id_reported) REFERENCES users(id) ON UPDATE CASCADE;

ALTER TABLE ONLY user_report
   ADD CONSTRAINT user_report_informer_fkey FOREIGN KEY (id_informer) REFERENCES users(id) ON UPDATE CASCADE;

ALTER TABLE ONLY user_subscribes
   ADD CONSTRAINT user_subscribes_followed_fkey FOREIGN KEY (id_followed) REFERENCES users(id) ON UPDATE CASCADE;

ALTER TABLE ONLY user_subscribes
   ADD CONSTRAINT user_subscribes_follower_fkey FOREIGN KEY (id_follower) REFERENCES users(id) ON UPDATE CASCADE;

ALTER TABLE ONLY administrator
   ADD CONSTRAINT administrator_fkey FOREIGN KEY (id) REFERENCES users(id) ON UPDATE CASCADE;

ALTER TABLE ONLY moderator
   ADD CONSTRAINT moderator_fkey FOREIGN KEY (id) REFERENCES users(id) ON UPDATE CASCADE;

ALTER TABLE ONLY kicked
   ADD CONSTRAINT kicked_fkey FOREIGN KEY (id) REFERENCES users(id) ON UPDATE CASCADE;

ALTER TABLE ONLY banned
   ADD CONSTRAINT banned_fkey FOREIGN KEY (id) REFERENCES kicked(id) ON UPDATE CASCADE;

ALTER TABLE ONLY suspended
   ADD CONSTRAINT suspended_fkey FOREIGN KEY (id) REFERENCES kicked(id) ON UPDATE CASCADE;

ALTER TABLE ONLY inactive
   ADD CONSTRAINT inactive_fkey FOREIGN KEY (id) REFERENCES users(id) ON UPDATE CASCADE;

ALTER TABLE ONLY verified
   ADD CONSTRAINT verified_fkey FOREIGN KEY (id) REFERENCES users(id) ON UPDATE CASCADE;

ALTER TABLE ONLY saves
   ADD CONSTRAINT saves_content_fkey FOREIGN KEY (id_content) REFERENCES content(id) ON UPDATE CASCADE;

ALTER TABLE ONLY saves
   ADD CONSTRAINT saves_user_fkey FOREIGN KEY (id_user) REFERENCES users(id) ON UPDATE CASCADE;

ALTER TABLE ONLY upvotes
   ADD CONSTRAINT upvotes_content_fkey FOREIGN KEY (id_content) REFERENCES content(id) ON UPDATE CASCADE;

ALTER TABLE ONLY upvotes
   ADD CONSTRAINT upvotes_user_fkey FOREIGN KEY (id_user) REFERENCES users(id) ON UPDATE CASCADE;

ALTER TABLE ONLY downvotes
   ADD CONSTRAINT downvotes_content_fkey FOREIGN KEY (id_content) REFERENCES content(id) ON UPDATE CASCADE;

ALTER TABLE ONLY downvotes
   ADD CONSTRAINT downvotes_user_fkey FOREIGN KEY (id_user) REFERENCES users(id) ON UPDATE CASCADE;

ALTER TABLE ONLY content_report
   ADD CONSTRAINT content_report_content_fkey FOREIGN KEY (id_content) REFERENCES content(id) ON UPDATE CASCADE;

ALTER TABLE ONLY content_report
   ADD CONSTRAINT content_report_user_fkey FOREIGN KEY (id_user) REFERENCES users(id) ON UPDATE CASCADE;

ALTER TABLE ONLY news_post
   ADD CONSTRAINT news_post_fkey FOREIGN KEY (id) REFERENCES content(id) ON UPDATE CASCADE;

ALTER TABLE ONLY "comment"
   ADD CONSTRAINT comment_fkey FOREIGN KEY (id) REFERENCES content(id) ON UPDATE CASCADE;

  ALTER TABLE ONLY "comment"
   ADD CONSTRAINT comment_user_fkey FOREIGN KEY (user_id) REFERENCES users(id) ON UPDATE CASCADE;


ALTER TABLE ONLY news_creation
   ADD CONSTRAINT news_creation_fkey FOREIGN KEY (id_news) REFERENCES news_post(id) ON UPDATE CASCADE;

-- INDEXES

CREATE INDEX user_id ON users USING hash (id);
CREATE INDEX title_order ON news_post USING btree (title);
CREATE INDEX dinamic_search_news ON news_post USING GIST ( to_tsvector('english', coalesce(title,'')));
CREATE INDEX dinamic_search_content ON content USING GIST ( to_tsvector('english', "text"));


-- TRIGGERS and UDFs

CREATE FUNCTION increment_comment() RETURNS TRIGGER AS
$BODY$
BEGIN

IF EXISTS (SELECT * FROM news_post WHERE NEW.parent_news = news_post.id) THEN
 UPDATE news_post SET comments_count = comments_count + 1
   WHERE news_post.id = NEW.parent_news;
   RETURN NEW;
END IF;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER comentar_post
 AFTER INSERT ON "comment"
 FOR EACH ROW
    EXECUTE PROCEDURE increment_comment();

CREATE FUNCTION news_post_upvote() RETURNS TRIGGER AS
$BODY$
BEGIN
IF EXISTS (SELECT * FROM upvotes WHERE NEW.id_content = upvotes.id_content AND NEW.id_user = upvotes.id_user) AND 
  NOT  EXISTS (SELECT * FROM downvotes WHERE NEW.id_content = downvotes.id_content AND NEW.id_user = downvotes.id_user) THEN
 UPDATE content SET votes = votes + 2
   WHERE content.id = NEW.id_content;
   RETURN NEW;
ELSIF NOT EXISTS (SELECT * FROM upvotes WHERE NEW.id_content = upvotes.id_content AND NEW.id_user = upvotes.id_user) AND 
  NOT EXISTS (SELECT * FROM downvotes WHERE NEW.id_content = downvotes.id_content AND NEW.id_user = downvotes.id_user)  THEN
  UPDATE content SET votes = votes + 1
   WHERE content.id = NEW.id_content;
   RETURN NEW;
ELSIF EXISTS (SELECT * FROM upvotes WHERE NEW.id_content = upvotes.id_content AND NEW.id_user = upvotes.id_user) AND 
  NOT EXISTS (SELECT * FROM downvotes WHERE NEW.id_content = downvotes.id_content AND NEW.id_user = downvotes.id_user) THEN
    UPDATE content SET votes = votes - 1
   WHERE content.id = NEW.id_content;
   RETURN NEW;
else RETURN NULL;
END IF;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER content_upvote_trigger
 BEFORE INSERT ON upvotes
 FOR EACH ROW
   EXECUTE PROCEDURE news_post_upvote();

--

CREATE FUNCTION news_post_downvote() RETURNS TRIGGER AS
$BODY$
BEGIN
IF EXISTS (SELECT * FROM upvotes WHERE NEW.id_content = upvotes.id_content AND NEW.id_user = upvotes.id_user) AND 
  NOT EXISTS (SELECT * FROM downvotes WHERE NEW.id_content = downvotes.id_content AND NEW.id_user = downvotes.id_user) THEN
 UPDATE content SET votes = votes - 2
   WHERE content.id = NEW.id_content;
   RETURN NEW;
ELSIF NOT EXISTS (SELECT * FROM downvotes WHERE NEW.id_content = downvotes.id_content AND NEW.id_user = downvotes.id_user) AND
   NOT EXISTS (SELECT * FROM upvotes WHERE NEW.id_content = upvotes.id_content AND NEW.id_user = upvotes.id_user) THEN
  UPDATE content SET votes = votes - 1
   WHERE content.id = NEW.id_content;
   RETURN NEW;
ELSIF EXISTS (SELECT * FROM downvotes WHERE NEW.id_content = downvotes.id_content AND NEW.id_user = downvotes.id_user) AND
   NOT EXISTS (SELECT * FROM upvotes WHERE NEW.id_content = upvotes.id_content AND NEW.id_user = upvotes.id_user)   THEN
   UPDATE content SET votes = votes + 1
   WHERE content.id = NEW.id_content;
   RETURN NEW;
  else  RETURN NULL;
END IF;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER content_downvote_trigger
 BEFORE INSERT ON downvotes
 FOR EACH ROW
   EXECUTE PROCEDURE news_post_downvote();

--

CREATE FUNCTION check_if_news_is_published() RETURNS TRIGGER AS
$BODY$
BEGIN
 IF OLD.ready = FALSE AND NEW.ready = TRUE THEN
   IF NOT EXISTS (SELECT ready FROM news_creation WHERE id_news = NEW.id_news AND ready = TRUE) THEN
      UPDATE news_post SET published = TRUE
      WHERE id = NEW.id_news;
   END IF;
 END IF;
 RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;


CREATE TRIGGER news_publication_trigger
 AFTER UPDATE ON news_creation
 FOR EACH ROW
   EXECUTE PROCEDURE check_if_news_is_published();

--

/*
CREATE FUNCTION news_delete_downvote() RETURNS TRIGGER AS
$BODY$
BEGIN
IF EXISTS (SELECT * FROM content WHERE OLD.id_content = content.id) THEN
 UPDATE content SET votes = votes + 1
   WHERE content.id = OLD.id_content;
   RETURN NEW;
END IF;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER content_downvote_delete
 BEFORE DELETE ON downvotes
 FOR EACH ROW
   EXECUTE PROCEDURE news_delete_downvote();



CREATE FUNCTION news_delete_upvote() RETURNS TRIGGER AS
$BODY$
BEGIN
IF EXISTS (SELECT * FROM content WHERE OLD.id_content = content.id) THEN
 UPDATE content SET votes = votes - 1
   WHERE content.id = OLD.id_content;
   RETURN NEW;
END IF;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER content_upvote_delete
 BEFORE DELETE ON upvotes
 FOR EACH ROW
   EXECUTE PROCEDURE news_delete_upvote();
*/

CREATE FUNCTION set_user_published() RETURNS TRIGGER AS
$BODY$
BEGIN
 IF OLD.ready = FALSE AND NEW.ready = TRUE THEN
   NEW.approval_date := now();
 END IF;
 RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER set_Aproval_date
 AFTER UPDATE ON news_creation
 FOR EACH ROW
   EXECUTE PROCEDURE set_user_published();

--

CREATE FUNCTION set_news_publish_date() RETURNS TRIGGER AS
$BODY$
BEGIN
 IF OLD.ready = FALSE AND NEW.ready = TRUE THEN
   IF NOT EXISTS (SELECT ready FROM news_creation WHERE id_news = NEW.id_news AND ready = TRUE) THEN
      UPDATE news_post SET published_date = now()
      WHERE id = NEW.id_news;
   END IF;
 END IF;
 RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER news_publish_date
 AFTER UPDATE ON news_creation
 FOR EACH ROW
   EXECUTE PROCEDURE set_news_publish_date();

--

/*
CREATE FUNCTION check_unique_values_user_f() RETURNS TRIGGER AS
$BODY$
BEGIN
 IF exists (select * from users where username = NEW.username or email = NEW.email or id = NEW.id) THEN
    RAISE EXCEPTION 'User already with either username: "%" or email: "%".', NEW.username, NEW.email;
    ROLLBACK;
 END IF;
 RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER check_unique_values_user
 BEFORE INSERT ON users
 FOR EACH ROW
   EXECUTE PROCEDURE check_unique_values_user_f();

--
*/

CREATE FUNCTION check_unique_value_tags_f() RETURNS TRIGGER AS
$BODY$
BEGIN
 IF exists (select * from tags where name = NEW.name or id = NEW.id) THEN
    RAISE EXCEPTION 'Tag "%" already exists', NEW.name;
    ROLLBACK;
 END IF;
 RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER check_unique_value_tags
 BEFORE INSERT ON tags
 FOR EACH ROW
   EXECUTE PROCEDURE check_unique_value_tags_f();

 INSERT INTO users (username,password,email,name,country,introduction,photo,followers,registered)
VALUES ('Kevin','$2y$10$RtncNiOZF3.Nd2KVqefXi.iAanZOkpo4JJmsqLktuTdW6TJRidV1q','kevin@jevin.com','Kevin Maria Fonseca','BR','I love collaborative news and I want to improve the quality of them!','default.jpg',8,'2018/05/21 10:45:12');
INSERT INTO users (username,password,email,name,country,introduction,photo,followers,registered)
VALUES ('Knowles','HFW83FAD8FZ','dapibus@malesuadavelvenenatis.edu','Addison Duffy',
'Afghanistan','volutpat. Nulla dignissim. Maecenas ornare egestas ligula. Nullam','Nielsen',87,'2018/05/20 10:45:12');
INSERT INTO users (username,password,email,name,country,introduction,photo,followers,registered)
VALUES ('Mckee','OTO55ZHO5UR','nonummy@necmalesuadaut.co.uk','Chandler Mack','Tonga',
'urna. Nullam lobortis quam a felis','Mcneil',156,'03/04/2018');
INSERT INTO users (username,password,email,name,country,introduction,photo,followers,registered)
VALUES ('Jordan','FJG13CFB0FM','quis.accumsan@augueSedmolestie.com','Steel Hicks','Greece',
'nisl. Maecenas malesuada fringilla est. Mauris','Strong',4,'04/05/2018');
INSERT INTO users (username,password,email,name,country,introduction,photo,followers,registered)
VALUES ('Barron','FQF22VDM5NP','dolor.sit.amet@Cras.edu','Perry Sosa','Cape Verde',
'natoque penatibus et magnis dis','Parrish',119,'2018/05/15 10:45:12');
INSERT INTO users (username,password,email,name,country,introduction,photo,followers,registered)
VALUES ('Powers','VRL89XUY3HE','enim.sit.amet@sollicitudinorci.com','Herman Torres',
'Latvia','tortor at risus. Nunc ac','Harrell',165,'2018/05/26 11:45:12');
INSERT INTO users (username,password,email,name,country,introduction,photo,followers,registered)
VALUES ('Hooper','EUR33HTL9TK','elit.a@semegestasblandit.edu','Colin Cote',
'Heard Island and Mcdonald Islands','feugiat placerat velit.','Bailey',14,'2018/01/22 08:45:12');
INSERT INTO users (username,password,email,name,country,introduction,photo,followers,registered)
VALUES ('Sawyer','XSB27PUS6OC','ac.arcu.Nunc@Fuscemilorem.co.uk','Arthur Kerr',
'Malta','tempor arcu. Vestibulum ut eros non enim commodo hendrerit. Donec','Klein',34,'2018/05/30 10:30:12');
INSERT INTO users (username,password,email,name,country,introduction,photo,followers,registered)
VALUES ('Price','UUZ76WQD8AY','Morbi@consectetuermauris.co.uk','Joel Mack','Saudi Arabia','ac','Mclaughlin',81,'2018/05/11 14:45:13');
INSERT INTO users (username,password,email,name,country,introduction,photo,followers,registered)
VALUES ('Daugherty','MEG47BZI3NY','leo.Vivamus@elit.ca','Felix Robbins','Myanmar','sed, sapien. Nunc','Freeman',178,'2018/06/05 10:45:12');
INSERT INTO users (username,password,email,name,country,introduction,photo,followers,registered)
VALUES ('Joao','DMEG47BZI3NY','jon.Vivamus@elit.ca','Joao Lago','Lago','sed, sopien. Nunc','Gordan',1,'2018/05/29 10:45:12');
INSERT INTO users (username,password,email,name,country,introduction,photo,followers,registered)
VALUES ('Jason','$2y$10$LnNSHQ3Qs77ymNqYAl.XJeDxS/ARi.pce16DmSiSkFxnk5u0uC.DG','jan.Vivamus@elit.ca','Jason Lago','LAago','sed, sopien. Nunc','Gordaan',1,'2018/05/28 10:45:12');

INSERT INTO "tags" (name,frequency) VALUES ('World',0);
INSERT INTO "tags" (name,frequency) VALUES ('Portugal',0);
INSERT INTO "tags" (name,frequency) VALUES ('Money',0);
INSERT INTO "tags" (name,frequency) VALUES ('Culture',0);
INSERT INTO "tags" (name,frequency) VALUES ('Politics',0);
INSERT INTO "tags" (name,frequency) VALUES ('Tech',0);
INSERT INTO "tags" (name,frequency) VALUES ('Science',0);
INSERT INTO "tags" (name,frequency) VALUES ('Health',0);
INSERT INTO "tags" (name,frequency) VALUES ('Sports',0);
INSERT INTO "tags" (name,frequency) VALUES ('Arts',0);
INSERT INTO "tags" (name,frequency) VALUES ('Books',0);
INSERT INTO "tags" (name,frequency) VALUES ('Style',0);
INSERT INTO "tags" (name,frequency) VALUES ('Food',0);
INSERT INTO "tags" (name,frequency) VALUES ('Cinema',0);
INSERT INTO "tags" (name,frequency) VALUES ('Music',0);
INSERT INTO "tags" (name,frequency) VALUES ('Opinion',0);
INSERT INTO "tags" (name,frequency) VALUES ('Other',0);

INSERT INTO "tags_post" (id_tag,id_post) VALUES (1,1);
INSERT INTO "tags_post" (id_tag,id_post) VALUES (2,1);
INSERT INTO "tags_post" (id_tag,id_post) VALUES (1,3);
INSERT INTO "tags_post" (id_tag,id_post) VALUES (2,3);



INSERT INTO "tags_subscribed" (id_tag,id_user) VALUES (9,2);
INSERT INTO "tags_subscribed" (id_tag,id_user) VALUES (2,7);
INSERT INTO "tags_subscribed" (id_tag,id_user) VALUES (9,4);
INSERT INTO "tags_subscribed" (id_tag,id_user) VALUES (4,9);
INSERT INTO "tags_subscribed" (id_tag,id_user) VALUES (7,6);
INSERT INTO "tags_subscribed" (id_tag,id_user) VALUES (8,10);
INSERT INTO "tags_subscribed" (id_tag,id_user) VALUES (7,8);
INSERT INTO "tags_subscribed" (id_tag,id_user) VALUES (10,2);
INSERT INTO "tags_subscribed" (id_tag,id_user) VALUES (4,7);
INSERT INTO "tags_subscribed" (id_tag,id_user) VALUES (1,10);
INSERT INTO "tags_subscribed" (id_tag,id_user) VALUES (4,2);
INSERT INTO "tags_subscribed" (id_tag,id_user) VALUES (5,2);
INSERT INTO "tags_subscribed" (id_tag,id_user) VALUES (6,8);

INSERT INTO "tags_blocked" (id_tag,id_user) VALUES (7,2);
INSERT INTO "tags_blocked" (id_tag,id_user) VALUES (9,5);
INSERT INTO "tags_blocked" (id_tag,id_user) VALUES (5,3);
INSERT INTO "tags_blocked" (id_tag,id_user) VALUES (7,5);
INSERT INTO "tags_blocked" (id_tag,id_user) VALUES (9,8);
INSERT INTO "tags_blocked" (id_tag,id_user) VALUES (5,8);
INSERT INTO "tags_blocked" (id_tag,id_user) VALUES (2,7);
INSERT INTO "tags_blocked" (id_tag,id_user) VALUES (7,9);
INSERT INTO "tags_blocked" (id_tag,id_user) VALUES (1,3);

INSERT INTO "user_report" (id_reported,id_informer,reason)
VALUES (6,8,'o user insultou-me');
INSERT INTO "user_report" (id_reported,id_informer,reason)
VALUES (6,4,'VIvaz. Não respeitou a Content Policy.');
INSERT INTO "user_report" (id_reported,id_informer,reason)
VALUES (3,3,'Reportou-me sem motivo aparente.');
INSERT INTO "user_report" (id_reported,id_informer,reason)
VALUES (9,4,'Favoritou todos os meus posts. Stalker.');
INSERT INTO "user_report" (id_reported,id_informer,reason)
VALUES (9,3,'Comentários abusivos');
INSERT INTO "user_report" (id_reported,id_informer,reason)
VALUES (9,5,'Conteúdo do utilizador não corresponde ao motivo do site.');
INSERT INTO "user_report" (id_reported,id_informer,reason)
VALUES (10,9,'Não me sinto seguro com este user na comunidade');

INSERT INTO "user_subscribes" (id_followed,id_follower) VALUES (2,6);
INSERT INTO "user_subscribes" (id_followed,id_follower) VALUES (5,3);
INSERT INTO "user_subscribes" (id_followed,id_follower) VALUES (6,5);
INSERT INTO "user_subscribes" (id_followed,id_follower) VALUES (5,6);
INSERT INTO "user_subscribes" (id_followed,id_follower) VALUES (2,10);

INSERT INTO "administrator" (id,started) VALUES (5, '2018/06/04 10:45:12');
INSERT INTO "administrator" (id,started) VALUES (12, '2018/05/30 10:45:12');

INSERT INTO "moderator" (id,started) VALUES (4, '2018/04/04 10:45:12');
INSERT INTO "moderator" (id,started) VALUES (7, '2018/04/03 10:45:12');

INSERT INTO "kicked" (id,ban_date,reason) VALUES (3, '2018/04/02 10:45:12', 'Abusive comments, swearing too much');
INSERT INTO "kicked" (id,ban_date,reason) VALUES (6, '2018/04/01 13:45:12', 'Very unhealthy behaviour.');

INSERT INTO "banned" (id) VALUES (3);

INSERT INTO "suspended" (id,days) VALUES (6, 2);

INSERT INTO "inactive" (id,deletion_date) VALUES (9, '05/05/2018');

INSERT INTO "verified" (id,status,verified) VALUES (8, 'Verified', '10/10/2018');

INSERT INTO "content" (votes,text,created)
VALUES (123,'<p>O F. C. Porto apresentou esta quarta-feira o equipamento principal para a próxima época 2018/19, numa publicação nas redes sociais.
A publicação foi feita na conta oficial do Twitter da equipa do F. C. Porto e na fotografia aparecem Gonçalo Paciência, Óliver Torres e José Sá.</p>','2018/04/04 10:45:12');
INSERT INTO "content" (votes,text,created)
VALUES (136,'<p>De acordo com o programa oficial do gabinete do primeiro-ministro, Merkel chega às 15 horas ao Aeroporto Francisco Sá Carneiro, no Porto, onde será recebida com honras militares, partindo para Braga às 15.15 horas.</p>','2018/04/04 10:45:12');
INSERT INTO "content" (votes,text,created)
VALUES (51,'<p>Conheça a chave vencedora do sorteio do Euromilhões desta terça-feira.

Os números vencedores são: 6, 11, 20, 38, 43 e as estrelas 2 e 4.</p>','2018/04/04 10:45:12');
INSERT INTO "content" (votes,text,created)
VALUES (91,'<p>A Assembleia da República discute e vota esta terça-feira os projetos de lei sobre a despenalização da morte medicamente assistida, numa pouco habitual votação deputado a deputado e de resultado imprevisível.</p>','07/01/2018');
INSERT INTO "content" (votes,text,created)
VALUES (157,'<p>O estudo, realizado por Manuel Pedro Carrapatoso sob a coordenação do professor Rui Nunes, inquiriu 405 estudantes do sexto ano de todas as universidades portuguesas em 2017. E revela uma posição contrária à da Ordem dos Médicos.</p>','2018/04/01 10:45:12');
INSERT INTO "content" (votes,text,created)
VALUES (95,'<p>Em resposta a perguntas da agência Lusa, a Associação Portuguesa de Seguradores (APS) afirma que uma eventual aprovação de legislação sobre eutanásia "não será neutra em matéria de seguros de vida, face à legislação que hoje disciplina os contratos de seguro".</p>','03/12/2018');
INSERT INTO "content" (votes,text,created)
VALUES (152,'<p>Números do Ministério da Saúde a que a agência Lusa teve acesso, mostram que há atualmente 376 camas de internamento em cuidados paliativos na rede pública.

Entre o início dos anos 1990 e 2015 foram criadas 362 camas e em 2017 foi criada a unidade de cuidados paliativos do Baixo Vouga, com 14 camas.</p>','2018/04/01 10:45:12');
INSERT INTO "content" (votes,text,created)
VALUES (156,'<p>A morte medicamente assistida é crime em Portugal, mas há portugueses a recorrerem à prática na Suíça e a encomendarem comprimidos do estrangeiro, comprados pela Internet, sem controlo, nem investigação.</p>','2018/01/04 10:45:12');
INSERT INTO "content" (votes,text,created)
VALUES (61,'<p>Segundo o Instituto Português do Mar e da Atmosfera (IPMA), os distritos de Bragança, Guarda, Vila Real e Castelo Branco vão estar entre as 12 horas e as 21 horas sob aviso amarelo devido à previsão de aguaceiros por vezes fortes, de granizo e acompanhados de trovoada.</p>','2018/04/29 10:45:12');
INSERT INTO "content" (votes,text,created)
VALUES (22,'<p>Nestes concelhos do sul do distrito de Vila Real, a chuva forte chegou na segunda-feira acompanhada de granizo, deixando um cenário, em algumas vinhas, de folhas esfarrapadas, galhos quebrados e bagos no chão, muros caídos e deslizamentos de terras.</p>','2018/04/24 10:45:12');
INSERT INTO "content" (votes,text,created)
VALUES (65,'Um jovem de 25 anos sofreu ferimentos considerados muito graves, esta terça-feira, após cair de uma altura de "cerca de três a quatro metros" quando estava em cima de um carregador frontal a cortar árvores em Pondras, Montalegre.

O comandante dos bombeiros de Salto, Hernâni Carvalho, explicou que "a vítima estava a trabalhar com uma máquina agrícola quando sofreu a queda". "Ele estava a cortar árvores com uma motosserra em cima do frontal. Estaria a uma altura de cerca de três a quatro metros", explicou o comandante dos voluntários de Salto.','2018/05/17 10:45:12');
INSERT INTO "content" (votes,text,created)
VALUES (65,'Um homem de 72 anos ficou preso debaixo de um trator durante cerca de uma hora, esta terça-feira, na sequência de um capotamento, na localidade de Adães, em Chaves.

O septuagenário conseguiu libertar-se depois de escavar um buraco com as mãos e com a ajuda de um vizinho que apareceu, mais tarde, no local do acidente.','2018/05/17 10:45:12');
INSERT INTO "content" (votes,text,created)
VALUES (65,'<p>O Ministério Público (MP) acusou um homem de 19 anos por quatro crimes de tentativas de violação e um crime de violação consumada, na cidade de Faro, no Algarve, anunciou esta terça-feira a Procuradoria da Comarca de Faro.</p>','2018/05/17 10:45:12');
INSERT INTO "content" (votes,text,created)
VALUES (65,'A Associação Portuguesa para a Defesa do Consumidor (DECO) anunciou esta quarta-feira que vai avançar com uma ação em tribunal contra o Facebook para garantir que os portugueses com conta naquela rede social sejam indemnizados pelo uso indevido de dados.','2018/05/17 10:45:12');

INSERT INTO "saves" (id_content,id_user) VALUES (6,5);
INSERT INTO "saves" (id_content,id_user) VALUES (9,10);
INSERT INTO "saves" (id_content,id_user) VALUES (5,10);
INSERT INTO "saves" (id_content,id_user) VALUES (10,6);
INSERT INTO "saves" (id_content,id_user) VALUES (2,5);
INSERT INTO "saves" (id_content,id_user) VALUES (6,8);
INSERT INTO "saves" (id_content,id_user) VALUES (9,6);

INSERT INTO "upvotes" (id_content,id_user) VALUES (5,3);
INSERT INTO "upvotes" (id_content,id_user) VALUES (9,6);
INSERT INTO "upvotes" (id_content,id_user) VALUES (3,10);
INSERT INTO "upvotes" (id_content,id_user) VALUES (4,9);
INSERT INTO "upvotes" (id_content,id_user) VALUES (8,7);
INSERT INTO "upvotes" (id_content,id_user) VALUES (7,7);
INSERT INTO "upvotes" (id_content,id_user) VALUES (2,4);

INSERT INTO "downvotes" (id_content,id_user) VALUES (3,9);
INSERT INTO "downvotes" (id_content,id_user) VALUES (6,8);
INSERT INTO "downvotes" (id_content,id_user) VALUES (7,6);
INSERT INTO "downvotes" (id_content,id_user) VALUES (8,9);
INSERT INTO "downvotes" (id_content,id_user) VALUES (3,2);
INSERT INTO "downvotes" (id_content,id_user) VALUES (3,7);
INSERT INTO "downvotes" (id_content,id_user) VALUES (8,10);
INSERT INTO "downvotes" (id_content,id_user) VALUES (3,3);

INSERT INTO "content_report" (id_content,id_user,reason,date)
VALUES (3,2,'Vile language','2018/04/19 10:45:12');
INSERT INTO "content_report" (id_content,id_user,reason,date)
VALUES (9,6,'not constructive','2018/04/18 10:45:12');
INSERT INTO "content_report" (id_content,id_user,reason,date)
VALUES (1,2,'very good. i love the idea','2018/04/10 10:45:12');

INSERT INTO "news_post" (id,title,"description",slug,comments_count,views,authors,published,published_date)
VALUES (1,'F.C.Porto','Camisolas','fcporto-shirts',0,161,3,FALSE,'2017/10/17 10:45:12');
INSERT INTO "news_post" (id,title,"description",slug,comments_count,views,authors,published,published_date)
VALUES (2,'Primeiro-ministro português e Merkel','Receção no Aeroporto','merkel-no-porto',0,186,1,TRUE,'2017/10/17 10:45:12');
INSERT INTO "news_post" (id,title,"description",slug,comments_count,views,authors,published,published_date)
VALUES (3,'Chave euromilhoes','saiba se é um milionário','euromilhoes-chave',0,174,2,FALSE,'2017/10/17 08:45:12');
INSERT INTO "news_post" (id,title,"description",slug,comments_count,views,authors,published,published_date)
VALUES (4,'Discussão na Assembleia','politicos defrontam-se fervorosamente','assembleia-discussao',0,83,1,TRUE,'2017/08/17 11:45:12');
INSERT INTO "news_post" (id,title,"description",slug,comments_count,views,authors,published,published_date)
VALUES (5,'Estudo sobre estudantes e a eutanásia','Posição dos jovens médicos','eutanasia-estudantes',0,143,1,FALSE,'2017/07/27 10:45:12');
INSERT INTO "news_post" (id,title,"description",slug,comments_count,views,authors,published,published_date)
VALUES (6,'Eutanásia e os seguros de vida','Seguradores discutem a controvérsia','entanasia-seguradoras',0,79,3,FALSE,'2017/10/17 10:45:12');
INSERT INTO "news_post" (id,title,"description",slug,comments_count,views,authors,published,published_date)
VALUES (7,'Cuidados paliativos na saúde pública','Falta de camas no centro','saude-publica',0,55,1,FALSE,'2017/10/27 10:45:12');
INSERT INTO "news_post" (id,title,"description",slug,comments_count,views,authors,published,published_date)
VALUES (8,'Morte medicamente assistida no estrangeiro','Portugueses recorrem ao estrangeiro','eutanasia-solucoes',0,2,2,TRUE,'2017/11/17 10:45:12');
INSERT INTO "news_post" (id,title,"description",slug,comments_count,views,authors,published,published_date)
VALUES (9,'Meteorologia: GRAVE','Risco de tempestade no Norte do país','tempo-norte',0,22,5,TRUE,'2017/11/27 10:45:12');
INSERT INTO "news_post" (id,title,"description",slug,comments_count,views,authors,published,published_date)
VALUES (10,'Meterologia: chuvas fortes','Vila Real passou um mau bocado','tempo-chuva',0,19,1,FALSE,'2017/10/17 10:45:12');

INSERT INTO "comment" (id,user_id,parent_comment,parent_news) VALUES (11,9,2,2);
INSERT INTO "comment" (id,user_id,parent_comment,parent_news) VALUES (12,10,7,8);
INSERT INTO "comment" (id,user_id,parent_comment,parent_news) VALUES (13,5,1,10);
INSERT INTO "comment" (id,user_id,parent_comment,parent_news) VALUES (14,4,7,9);

INSERT INTO "news_creation" (id_news,id_user,ready,approval_date) VALUES (1,2,TRUE,'2018/11/17 10:45:12');
INSERT INTO "news_creation" (id_news,id_user,ready,approval_date) VALUES (1,3,FALSE,null);
INSERT INTO "news_creation" (id_news,id_user,ready,approval_date) VALUES (2,5,TRUE,'2018/11/18 10:45:12');
INSERT INTO "news_creation" (id_news,id_user,ready,approval_date) VALUES (3,6,TRUE,'2018/10/17 10:45:12');
INSERT INTO "news_creation" (id_news,id_user,ready,approval_date) VALUES (4,8,TRUE,'2018/10/16 11:45:12');
INSERT INTO "news_creation" (id_news,id_user,ready,approval_date) VALUES (5,7,FALSE,null);
INSERT INTO "news_creation" (id_news,id_user,ready,approval_date) VALUES (6,5,TRUE,'2018/10/17 11:45:12');
INSERT INTO "news_creation" (id_news,id_user,ready,approval_date) VALUES (7,3,FALSE,null);
INSERT INTO "news_creation" (id_news,id_user,ready,approval_date) VALUES (8,2,TRUE,'2018/10/10 11:45:12');
INSERT INTO "news_creation" (id_news,id_user,ready,approval_date) VALUES (9,9,FALSE,null);
INSERT INTO "news_creation" (id_news,id_user,ready,approval_date) VALUES (10,6,FALSE,null);

/*
ALTER TABLE "question" ADD COLUMN textsearchable_index_col tsvector;
UPDATE "question" SET textsearchable_index_col =
 to_tsvector('english', coalesce(short_message,'')||' '|| coalesce(long_message,''));
CREATE OR REPLACE FUNCTION question_search_update() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF TG_OP = 'INSERT' THEN
        NEW.textsearchable_index_col = to_tsvector('english', coalesce(NEW.short_message,'')||' '|| coalesce(NEW.long_message,''));
    END IF;
    IF TG_OP = 'UPDATE' THEN
        IF NEW.short_message <> OLD.short_message THEN
            NEW.textsearchable_index_col = to_tsvector('english', coalesce(NEW.short_message,'')||' '|| coalesce(OLD.long_message,''));
        END IF;
        IF NEW.long_message <> OLD.long_message THEN
            NEW.textsearchable_index_col = to_tsvector('english', coalesce(OLD.short_message,'')||' '|| coalesce(NEW.long_message,''));
        END IF;
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;
CREATE TRIGGER question_search_update
    AFTER INSERT OR UPDATE ON question
    FOR EACH ROW 
        EXECUTE PROCEDURE question_search_update();

*/


ALTER TABLE news_post ADD COLUMN textsearchable_name_col tsvector;
UPDATE news_post SET textsearchable_name_col = to_tsvector('english', title);

ALTER TABLE content ADD COLUMN textsearchable_name_col tsvector;
UPDATE content SET textsearchable_name_col = to_tsvector('english', text);


CREATE FUNCTION post_search() RETURNS TRIGGER AS
$BODY$
BEGIN
IF NEW.textsearchable_name_col is null THEN
  NEW.textsearchable_name_col = to_tsvector('english', NEW.title);
END IF;  
RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER news_post
BEFORE INSERT ON news_post
FOR EACH ROW
  EXECUTE PROCEDURE post_search();

CREATE FUNCTION content_search() RETURNS TRIGGER AS
$BODY$
BEGIN
IF NEW.textsearchable_name_col is null THEN
  NEW.textsearchable_name_col = to_tsvector('english', NEW.text);
END IF;  
RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER content
BEFORE INSERT ON content
FOR EACH ROW
  EXECUTE PROCEDURE content_search();
