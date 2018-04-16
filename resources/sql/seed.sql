DROP TABLE IF EXISTS comment_creation CASCADE;
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
DROP TABLE IF EXISTS "user" CASCADE;
DROP FUNCTION IF EXISTS news_post_upvote();
DROP FUNCTION IF EXISTS news_post_downvote();
DROP FUNCTION IF EXISTS check_if_news_is_published() CASCADE;
DROP FUNCTION IF EXISTS set_user_published() CASCADE;
DROP FUNCTION IF EXISTS set_news_publish_date() CASCADE;
DROP FUNCTION IF EXISTS check_unique_values_user_f();
DROP FUNCTION IF EXISTS check_unique_value_tags_f();


CREATE TABLE "user" (
   id SERIAL NOT NULL,
   username text NOT NULL,
   password text NOT NULL,
   email text NOT NULL,
   name text,
   country text,
   introduction text,
   photo text,
   followers INTEGER,
   registered TIMESTAMP WITH TIME zone DEFAULT now() NOT NULL,
   CONSTRAINT followers_positive CHECK ((followers >= 0))
);

CREATE TABLE tags (
       id SERIAL NOT NULL,
   name text NOT NULL,
   frequency Integer,
   CONSTRAINT frequency_positive CHECK ((frequency >= 0))
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
   id_user Integer NOT NULL,
   started TIMESTAMP WITH TIME zone DEFAULT now() NOT NULL
);

CREATE TABLE moderator (
   id_user Integer NOT NULL,
   started TIMESTAMP WITH TIME zone DEFAULT now() NOT NULL
);

CREATE TABLE kicked (
   id_user Integer NOT NULL,
   ban_date TIMESTAMP WITH TIME zone DEFAULT now() NOT NULL,
   reason text
);

CREATE TABLE banned (
   id_user Integer NOT NULL
);

CREATE TABLE suspended (
   id_user Integer NOT NULL,
   days Integer NOT NULL,
   CONSTRAINT days_positive CHECK ((days > 0))
);

CREATE TABLE inactive (
   id_user Integer NOT NULL,
   deletion_date TIMESTAMP WITH TIME zone DEFAULT now() NOT NULL
);

CREATE TABLE verified (
   id_user Integer NOT NULL,
   status text NOT NULL,
   verified TIMESTAMP WITH TIME zone,
   CONSTRAINT status_enum CHECK ((status = ANY (ARRAY['Verified'::text, 'Pending'::text, 'Unconfirmed'::text]))),
   CONSTRAINT verified_date CHECK ((verified > now()))
);

CREATE TABLE content (
   id SERIAL NOT NULL,
   votes Integer,
   "text" Text NOT NULL,
   created TIMESTAMP WITH TIME zone DEFAULT now()

);

CREATE TABLE saves (
   id_content Integer NOT NULL,
   id_user Integer NOT NULL
);

CREATE TABLE upvotes (
   id_content Integer NOT NULL,
   id_user Integer NOT NULL
);

CREATE TABLE downvotes (
   id_content Integer NOT NULL,
   id_user Integer NOT NULL
);

CREATE TABLE content_report (
   id_content Integer NOT NULL,
   id_user Integer NOT NULL,
   reason text,
   "date" TIMESTAMP WITH TIME zone DEFAULT now()
);

CREATE TABLE news_post (
   id_content Integer NOT NULL,
   title text,
   photo text,
   comments Integer,
   views Integer,
   authors Integer,
   published BOOLEAN NOT NULL,
   published_date TIMESTAMP WITH TIME zone,
   CONSTRAINT views_positive CHECK ((views >= 0)),
   CONSTRAINT comments_positive CHECK ((comments >= 0)),
   CONSTRAINT published_date_positive CHECK ((published_date >= now()))
);

CREATE TABLE "comment" (
   id_content Integer NOT NULL,
   parent_comment  Integer,
   parent_news  Integer NOT NULL
);

CREATE TABLE comment_creation (
   id_comment Integer NOT NULL,
   id_user Integer NOT NULL
);

CREATE TABLE news_creation (
   id_news Integer NOT NULL,
   id_user Integer NOT NULL,
   ready BOOLEAN NOT NULL,
   approval_date TIMESTAMP WITH TIME zone,
   CONSTRAINT approval_date_positive CHECK ((approval_date >= now()))

);


--Primary_Keys_and_Uniques

ALTER TABLE ONLY "user"
   ADD CONSTRAINT user_pkey PRIMARY KEY (id);

ALTER TABLE ONLY "user"
   ADD CONSTRAINT user_ukey_username UNIQUE (username);

ALTER TABLE ONLY "user"
   ADD CONSTRAINT user_ukey_password UNIQUE (password);

ALTER TABLE ONLY "user"
   ADD CONSTRAINT user_ukey_email UNIQUE (email);

ALTER TABLE ONLY tags
   ADD CONSTRAINT tags_pkey PRIMARY KEY (id);

ALTER TABLE ONLY tags
   ADD CONSTRAINT tags_ukey_name UNIQUE (name);

ALTER TABLE ONLY tags_subscribed
   ADD CONSTRAINT tags_subscribed_pkey PRIMARY KEY (id_tag, id_user);

ALTER TABLE ONLY tags_blocked
   ADD CONSTRAINT tags_blocked_pkey PRIMARY KEY (id_tag, id_user);

ALTER TABLE ONLY user_report
   ADD CONSTRAINT user_report_pkey PRIMARY KEY (id_reported, id_informer);

ALTER TABLE ONLY user_subscribes
   ADD CONSTRAINT user_subscribes_pkey PRIMARY KEY (id_followed, id_follower);

ALTER TABLE ONLY administrator
   ADD CONSTRAINT administrator_pkey PRIMARY KEY (id_user);

ALTER TABLE ONLY moderator
   ADD CONSTRAINT moderator_pkey PRIMARY KEY (id_user);

ALTER TABLE ONLY kicked
   ADD CONSTRAINT kicked_pkey PRIMARY KEY (id_user);

ALTER TABLE ONLY banned
   ADD CONSTRAINT banned_pkey PRIMARY KEY (id_user);

ALTER TABLE ONLY suspended
   ADD CONSTRAINT suspended_pkey PRIMARY KEY (id_user);

ALTER TABLE ONLY inactive
   ADD CONSTRAINT inactive_pkey PRIMARY KEY (id_user);

ALTER TABLE ONLY verified
   ADD CONSTRAINT verified_pkey PRIMARY KEY (id_user);

ALTER TABLE ONLY content
   ADD CONSTRAINT content_pkey PRIMARY KEY (id);

ALTER TABLE ONLY saves
   ADD CONSTRAINT saves_pkey PRIMARY KEY (id_content, id_user);

ALTER TABLE ONLY upvotes
   ADD CONSTRAINT upvotes_pkey PRIMARY KEY (id_content, id_user);

ALTER TABLE ONLY downvotes
   ADD CONSTRAINT downvotes_pkey PRIMARY KEY (id_content, id_user);

ALTER TABLE ONLY content_report
   ADD CONSTRAINT content_report_pkey PRIMARY KEY (id_content, id_user);

ALTER TABLE ONLY news_post
   ADD CONSTRAINT news_post_pkey PRIMARY KEY (id_content);

ALTER TABLE ONLY "comment"
   ADD CONSTRAINT comment_pkey PRIMARY KEY (id_content);

ALTER TABLE ONLY comment_creation
   ADD CONSTRAINT comment_creation_pkey PRIMARY KEY (id_comment, id_user);

ALTER TABLE ONLY news_creation
   ADD CONSTRAINT news_creation_pkey PRIMARY KEY (id_news, id_user);

--Foreign_Keys

ALTER TABLE ONLY tags_subscribed
   ADD CONSTRAINT tags_subscribed_tags_fkey FOREIGN KEY (id_tag) REFERENCES tags(id) ON UPDATE CASCADE;

ALTER TABLE ONLY tags_subscribed
   ADD CONSTRAINT tags_subscribed_user_fkey FOREIGN KEY (id_user) REFERENCES "user"(id) ON UPDATE CASCADE;

ALTER TABLE ONLY tags_blocked
   ADD CONSTRAINT tags_blocked_tags_fkey FOREIGN KEY (id_tag) REFERENCES tags(id) ON UPDATE CASCADE;

ALTER TABLE ONLY tags_blocked
   ADD CONSTRAINT tags_blocked_user_fkey FOREIGN KEY (id_user) REFERENCES "user"(id) ON UPDATE CASCADE;

ALTER TABLE ONLY user_report
   ADD CONSTRAINT user_report_reported_fkey FOREIGN KEY (id_reported) REFERENCES "user"(id) ON UPDATE CASCADE;

ALTER TABLE ONLY user_report
   ADD CONSTRAINT user_report_informer_fkey FOREIGN KEY (id_informer) REFERENCES "user"(id) ON UPDATE CASCADE;

ALTER TABLE ONLY user_subscribes
   ADD CONSTRAINT user_subscribes_followed_fkey FOREIGN KEY (id_followed) REFERENCES "user"(id) ON UPDATE CASCADE;

ALTER TABLE ONLY user_subscribes
   ADD CONSTRAINT user_subscribes_follower_fkey FOREIGN KEY (id_follower) REFERENCES "user"(id) ON UPDATE CASCADE;

ALTER TABLE ONLY administrator
   ADD CONSTRAINT administrator_fkey FOREIGN KEY (id_user) REFERENCES "user"(id) ON UPDATE CASCADE;

ALTER TABLE ONLY moderator
   ADD CONSTRAINT moderator_fkey FOREIGN KEY (id_user) REFERENCES "user"(id) ON UPDATE CASCADE;

ALTER TABLE ONLY kicked
   ADD CONSTRAINT kicked_fkey FOREIGN KEY (id_user) REFERENCES "user"(id) ON UPDATE CASCADE;

ALTER TABLE ONLY banned
   ADD CONSTRAINT banned_fkey FOREIGN KEY (id_user) REFERENCES kicked(id_user) ON UPDATE CASCADE;

ALTER TABLE ONLY suspended
   ADD CONSTRAINT suspended_fkey FOREIGN KEY (id_user) REFERENCES kicked(id_user) ON UPDATE CASCADE;

ALTER TABLE ONLY inactive
   ADD CONSTRAINT inactive_fkey FOREIGN KEY (id_user) REFERENCES "user"(id) ON UPDATE CASCADE;

ALTER TABLE ONLY verified
   ADD CONSTRAINT verified_fkey FOREIGN KEY (id_user) REFERENCES "user"(id) ON UPDATE CASCADE;

ALTER TABLE ONLY saves
   ADD CONSTRAINT saves_content_fkey FOREIGN KEY (id_content) REFERENCES content(id) ON UPDATE CASCADE;

ALTER TABLE ONLY saves
   ADD CONSTRAINT saves_user_fkey FOREIGN KEY (id_user) REFERENCES "user"(id) ON UPDATE CASCADE;

ALTER TABLE ONLY upvotes
   ADD CONSTRAINT upvotes_content_fkey FOREIGN KEY (id_content) REFERENCES content(id) ON UPDATE CASCADE;

ALTER TABLE ONLY upvotes
   ADD CONSTRAINT upvotes_user_fkey FOREIGN KEY (id_user) REFERENCES "user"(id) ON UPDATE CASCADE;

ALTER TABLE ONLY downvotes
   ADD CONSTRAINT downvotes_content_fkey FOREIGN KEY (id_content) REFERENCES content(id) ON UPDATE CASCADE;

ALTER TABLE ONLY downvotes
   ADD CONSTRAINT downvotes_user_fkey FOREIGN KEY (id_user) REFERENCES "user"(id) ON UPDATE CASCADE;

ALTER TABLE ONLY content_report
   ADD CONSTRAINT content_report_content_fkey FOREIGN KEY (id_content) REFERENCES content(id) ON UPDATE CASCADE;

ALTER TABLE ONLY content_report
   ADD CONSTRAINT content_report_user_fkey FOREIGN KEY (id_user) REFERENCES "user"(id) ON UPDATE CASCADE;

ALTER TABLE ONLY news_post
   ADD CONSTRAINT news_post_fkey FOREIGN KEY (id_content) REFERENCES content(id) ON UPDATE CASCADE;

ALTER TABLE ONLY "comment"
   ADD CONSTRAINT comment_fkey FOREIGN KEY (id_content) REFERENCES content(id) ON UPDATE CASCADE;

ALTER TABLE ONLY comment_creation
   ADD CONSTRAINT comment_creation_fkey FOREIGN KEY (id_comment) REFERENCES "comment"(id_content) ON UPDATE CASCADE;

ALTER TABLE ONLY news_creation
   ADD CONSTRAINT news_creation_fkey FOREIGN KEY (id_news) REFERENCES news_post(id_content) ON UPDATE CASCADE;

-- INDEXES

CREATE INDEX user_id ON "user" USING hash (id);
CREATE INDEX title_order ON news_post USING btree (title);
CREATE INDEX dinamic_search_news ON news_post USING GIST ( to_tsvector('english', coalesce(title,'')));
CREATE INDEX dinamic_search_content ON content USING GIST ( to_tsvector('english', "text"));


-- TRIGGERS and UDFs

CREATE FUNCTION news_post_upvote() RETURNS TRIGGER AS
$BODY$
BEGIN
 UPDATE content SET votes = votes + 1
   WHERE content.id = NEW.id_content;
   RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER content_upvote_trigger
 AFTER INSERT ON upvotes
 FOR EACH ROW
   EXECUTE PROCEDURE news_post_upvote();

--

CREATE FUNCTION news_post_downvote() RETURNS TRIGGER AS
$BODY$
BEGIN
 UPDATE content SET votes = votes - 1
   WHERE content.id = NEW.id_content;
   RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER content_downvote_trigger
 AFTER INSERT ON downvotes
 FOR EACH ROW
   EXECUTE PROCEDURE news_post_downvote();

--

CREATE FUNCTION check_if_news_is_published() RETURNS TRIGGER AS
$BODY$
BEGIN
 IF OLD.ready = FALSE AND NEW.ready = TRUE THEN
   IF NOT EXISTS (SELECT ready FROM news_creation WHERE id_news = NEW.id_news AND ready = TRUE) THEN
      UPDATE news_post SET published = TRUE
      WHERE id_content = NEW.id_news;
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
      WHERE id_content = NEW.id_news;
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

CREATE FUNCTION check_unique_values_user_f() RETURNS TRIGGER AS
$BODY$
BEGIN
 IF exists (select * from "user" where username = NEW.username or email = NEW.email or id = NEW.id) THEN
    RAISE EXCEPTION 'User already with either username: "%" or email: "%".', NEW.username, NEW.email;
    ROLLBACK;
 END IF;
 RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER check_unique_values_user
 BEFORE INSERT ON "user"
 FOR EACH ROW
   EXECUTE PROCEDURE check_unique_values_user_f();

--

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

 INSERT INTO "user" (id,username,password,email,name,country,introduction,photo,followers,registered)
VALUES (1,'Holder','DWK39TID7ER','est.tempor.bibendum@nonbibendum.ca','Lester Patrick','Montserrat','eu','French',8,'2018/06/21 10:45:12');
INSERT INTO "user" (id,username,password,email,name,country,introduction,photo,followers,registered)
VALUES (2,'Knowles','HFW83FAD8FZ','dapibus@malesuadavelvenenatis.edu','Addison Duffy',
'Afghanistan','volutpat. Nulla dignissim. Maecenas ornare egestas ligula. Nullam','Nielsen',87,'2018/06/20 10:45:12');
INSERT INTO "user" (id,username,password,email,name,country,introduction,photo,followers,registered)
VALUES (3,'Mckee','OTO55ZHO5UR','nonummy@necmalesuadaut.co.uk','Chandler Mack','Tonga',
'urna. Nullam lobortis quam a felis','Mcneil',156,'03/04/2019');
INSERT INTO "user" (id,username,password,email,name,country,introduction,photo,followers,registered)
VALUES (4,'Jordan','FJG13CFB0FM','quis.accumsan@augueSedmolestie.com','Steel Hicks','Greece',
'nisl. Maecenas malesuada fringilla est. Mauris','Strong',4,'04/08/2018');
INSERT INTO "user" (id,username,password,email,name,country,introduction,photo,followers,registered)
VALUES (5,'Barron','FQF22VDM5NP','dolor.sit.amet@Cras.edu','Perry Sosa','Cape Verde',
'natoque penatibus et magnis dis','Parrish',119,'2018/06/15 10:45:12');
INSERT INTO "user" (id,username,password,email,name,country,introduction,photo,followers,registered)
VALUES (6,'Powers','VRL89XUY3HE','enim.sit.amet@sollicitudinorci.com','Herman Torres',
'Latvia','tortor at risus. Nunc ac','Harrell',165,'2018/06/26 11:45:12');
INSERT INTO "user" (id,username,password,email,name,country,introduction,photo,followers,registered)
VALUES (7,'Hooper','EUR33HTL9TK','elit.a@semegestasblandit.edu','Colin Cote',
'Heard Island and Mcdonald Islands','feugiat placerat velit.','Bailey',14,'2018/06/22 08:45:12');
INSERT INTO "user" (id,username,password,email,name,country,introduction,photo,followers,registered)
VALUES (8,'Sawyer','XSB27PUS6OC','ac.arcu.Nunc@Fuscemilorem.co.uk','Arthur Kerr',
'Malta','tempor arcu. Vestibulum ut eros non enim commodo hendrerit. Donec','Klein',34,'2018/06/30 10:30:12');
INSERT INTO "user" (id,username,password,email,name,country,introduction,photo,followers,registered)
VALUES (9,'Price','UUZ76WQD8AY','Morbi@consectetuermauris.co.uk','Joel Mack','Saudi Arabia','ac','Mclaughlin',81,'2018/06/11 14:45:13');
INSERT INTO "user" (id,username,password,email,name,country,introduction,photo,followers,registered)
VALUES (10,'Daugherty','MEG47BZI3NY','leo.Vivamus@elit.ca','Felix Robbins','Myanmar','sed, sapien. Nunc','Freeman',178,'2018/06/05 10:45:12');

INSERT INTO "tags" (id,name,frequency) VALUES (1,'Duis',159);
INSERT INTO "tags" (id,name,frequency) VALUES (2,'Donec',179);
INSERT INTO "tags" (id,name,frequency) VALUES (3,'semper',140);
INSERT INTO "tags" (id,name,frequency) VALUES (4,'cursus',199);
INSERT INTO "tags" (id,name,frequency) VALUES (5,'fringilla',193);
INSERT INTO "tags" (id,name,frequency) VALUES (6,'ut',10);
INSERT INTO "tags" (id,name,frequency) VALUES (7,'scelerisque',67);
INSERT INTO "tags" (id,name,frequency) VALUES (8,'arcu',57);
INSERT INTO "tags" (id,name,frequency) VALUES (9,'erat',46);
INSERT INTO "tags" (id,name,frequency) VALUES (10,'ante',92);
INSERT INTO "tags" (id,name,frequency) VALUES (11,'lectus,',174);

INSERT INTO "tags_subscribed" (id_tag,id_user) VALUES (9,1);
INSERT INTO "tags_subscribed" (id_tag,id_user) VALUES (2,7);
INSERT INTO "tags_subscribed" (id_tag,id_user) VALUES (9,4);
INSERT INTO "tags_subscribed" (id_tag,id_user) VALUES (4,9);
INSERT INTO "tags_subscribed" (id_tag,id_user) VALUES (7,6);
INSERT INTO "tags_subscribed" (id_tag,id_user) VALUES (8,10);
INSERT INTO "tags_subscribed" (id_tag,id_user) VALUES (7,8);
INSERT INTO "tags_subscribed" (id_tag,id_user) VALUES (10,1);
INSERT INTO "tags_subscribed" (id_tag,id_user) VALUES (4,7);
INSERT INTO "tags_subscribed" (id_tag,id_user) VALUES (1,10);
INSERT INTO "tags_subscribed" (id_tag,id_user) VALUES (4,2);
INSERT INTO "tags_subscribed" (id_tag,id_user) VALUES (5,2);
INSERT INTO "tags_subscribed" (id_tag,id_user) VALUES (6,8);

INSERT INTO "tags_blocked" (id_tag,id_user) VALUES (7,1);
INSERT INTO "tags_blocked" (id_tag,id_user) VALUES (9,5);
INSERT INTO "tags_blocked" (id_tag,id_user) VALUES (5,3);
INSERT INTO "tags_blocked" (id_tag,id_user) VALUES (7,5);
INSERT INTO "tags_blocked" (id_tag,id_user) VALUES (9,8);
INSERT INTO "tags_blocked" (id_tag,id_user) VALUES (5,8);
INSERT INTO "tags_blocked" (id_tag,id_user) VALUES (2,7);
INSERT INTO "tags_blocked" (id_tag,id_user) VALUES (7,9);
INSERT INTO "tags_blocked" (id_tag,id_user) VALUES (1,1);

INSERT INTO "user_report" (id_reported,id_informer,reason)
VALUES (6,8,'ipsum porta');
INSERT INTO "user_report" (id_reported,id_informer,reason)
VALUES (6,4,'viverra. Maecenas iaculis aliquet diam.');
INSERT INTO "user_report" (id_reported,id_informer,reason)
VALUES (3,3,'eleifend egestas. Sed pharetra, felis eget varius ultrices,');
INSERT INTO "user_report" (id_reported,id_informer,reason)
VALUES (9,4,'Donec egestas. Duis');
INSERT INTO "user_report" (id_reported,id_informer,reason)
VALUES (9,3,'malesuada');
INSERT INTO "user_report" (id_reported,id_informer,reason)
VALUES (9,1,'arcu. Vivamus sit');
INSERT INTO "user_report" (id_reported,id_informer,reason)
VALUES (10,9,'dui. Fusce aliquam, enim nec');

INSERT INTO "user_subscribes" (id_followed,id_follower) VALUES (2,6);
INSERT INTO "user_subscribes" (id_followed,id_follower) VALUES (1,3);
INSERT INTO "user_subscribes" (id_followed,id_follower) VALUES (6,1);
INSERT INTO "user_subscribes" (id_followed,id_follower) VALUES (5,6);
INSERT INTO "user_subscribes" (id_followed,id_follower) VALUES (2,10);

INSERT INTO "administrator" (id_user,started) VALUES (1, '2018/06/04 10:45:12');

INSERT INTO "moderator" (id_user,started) VALUES (4, '2018/04/04 10:45:12');
INSERT INTO "moderator" (id_user,started) VALUES (7, '2018/04/03 10:45:12');

INSERT INTO "kicked" (id_user,ban_date,reason) VALUES (3, '2018/04/02 10:45:12', 'lorem ipsum');
INSERT INTO "kicked" (id_user,ban_date,reason) VALUES (6, '2018/04/01 13:45:12', 'lorem ipsum lorem');

INSERT INTO "banned" (id_user) VALUES (3);

INSERT INTO "suspended" (id_user,days) VALUES (6, 2);

INSERT INTO "inactive" (id_user,deletion_date) VALUES (9, '05/05/2018');

INSERT INTO "verified" (id_user,status,verified) VALUES (8, 'Verified', '05/04/2018');

INSERT INTO "content" (id,votes,text,created)
VALUES (11,123,'Vestibulum accumsan neque et nunc.','2018/04/04 10:45:12');
INSERT INTO "content" (id,votes,text,created)
VALUES (7,136,'facilisis non, bibendum sed, est. Nunc laoreet lectus quis massa.
Mauris vestibulum, neque sed dictum eleifend, nunc risus varius','2018/06/04 10:45:12');
INSERT INTO "content" (id,votes,text,created)
VALUES (8,51,'dui. Suspendisse ac metus vitae','2019/04/04 10:45:12');
INSERT INTO "content" (id,votes,text,created)
VALUES (4,91,'Curabitur consequat, lectus sit amet luctus vulputate, nisi sem semper','07/11/2018');
INSERT INTO "content" (id,votes,text,created)
VALUES (3,157,'Sed eu eros. Nam consequat dolor vitae dolor. Donec fringilla.
Donec feugiat metus sit amet ante. Vivamus non','2018/04/01 10:45:12');
INSERT INTO "content" (id,votes,text,created)
VALUES (1,95,'orci, consectetuer euismod est arcu ac orci. Ut semper pretium neque.','03/12/2018');
INSERT INTO "content" (id,votes,text,created)
VALUES (10,152,'Pellentesque habitant morbi','2018/04/01 10:45:12');
INSERT INTO "content" (id,votes,text,created)
VALUES (5,156,'ipsum dolor sit amet, consectetuer adipiscing elit. Etiam laoreet,
libero et tristique pellentesque, tellus sem mollis dui,','2018/01/04 10:45:12');
INSERT INTO "content" (id,votes,text,created)
VALUES (2,61,'id risus quis diam luctus lobortis. Class aptent taciti sociosqu
ad litora torquent per conubia nostra, per','2018/04/29 10:45:12');
INSERT INTO "content" (id,votes,text,created)
VALUES (9,22,'adipiscing lobortis risus. In mi pede, nonummy ut, molestie','2018/04/24 10:45:12');
INSERT INTO "content" (id,votes,text,created)
VALUES (6,65,'Mauris vel turpis. Aliquam adipiscing lobortis','2018/04/17 10:45:12');
INSERT INTO "content" (id,votes,text,created)
VALUES (18,65,'Mauris vel turpis. Aliquam adipiscing lobortis','2018/04/17 10:45:12');
INSERT INTO "content" (id,votes,text,created)
VALUES (13,65,'Mauris vel turpis. Aliquam adipiscing lobortis','2018/04/17 10:45:12');
INSERT INTO "content" (id,votes,text,created)
VALUES (15,65,'Mauris vel turpis. Aliquam adipiscing lobortis','2018/04/17 10:45:12');

INSERT INTO "saves" (id_content,id_user) VALUES (6,5);
INSERT INTO "saves" (id_content,id_user) VALUES (9,10);
INSERT INTO "saves" (id_content,id_user) VALUES (5,10);
INSERT INTO "saves" (id_content,id_user) VALUES (10,6);
INSERT INTO "saves" (id_content,id_user) VALUES (2,1);
INSERT INTO "saves" (id_content,id_user) VALUES (6,8);
INSERT INTO "saves" (id_content,id_user) VALUES (9,1);

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
INSERT INTO "downvotes" (id_content,id_user) VALUES (3,1);
INSERT INTO "downvotes" (id_content,id_user) VALUES (8,10);
INSERT INTO "downvotes" (id_content,id_user) VALUES (3,3);

INSERT INTO "content_report" (id_content,id_user,reason,date)
VALUES (3,2,'sem. Nulla interdum. Curabitur dictum. Phasellus','2018/04/19 10:45:12');
INSERT INTO "content_report" (id_content,id_user,reason,date)
VALUES (9,1,'erat nonummy ultricies ornare, elit elit fermentum','2018/04/18 10:45:12');
INSERT INTO "content_report" (id_content,id_user,reason,date)
VALUES (1,2,'nonummy ut, molestie in, tempus eu, ligula. Aenean euismod','2018/04/10 10:45:12');

INSERT INTO "news_post" (id_content,title,photo,comments,views,authors,published,published_date)
VALUES (4,'ante. Maecenas','Curabitur',62,161,3,FALSE,'2018/10/17 10:45:12');
INSERT INTO "news_post" (id_content,title,photo,comments,views,authors,published,published_date)
VALUES (10,'ornare egestas ligula. Nullam','facilisis,',159,186,1,TRUE,'2018/05/17 10:45:12');
INSERT INTO "news_post" (id_content,title,photo,comments,views,authors,published,published_date)
VALUES (8,'nascetur ridiculus mus. Donec dignissim','et,',34,174,2,FALSE,'2018/05/17 08:45:12');
INSERT INTO "news_post" (id_content,title,photo,comments,views,authors,published,published_date)
VALUES (2,'turpis egestas. Fusce aliquet magna','sem',74,83,1,TRUE,'2018/08/17 11:45:12');
INSERT INTO "news_post" (id_content,title,photo,comments,views,authors,published,published_date)
VALUES (6,'metus. Vivamus euismod','netus',103,143,1,FALSE,'2018/04/27 10:45:12');
INSERT INTO "news_post" (id_content,title,photo,comments,views,authors,published,published_date)
VALUES (9,'risus.','eu,',146,79,3,FALSE,'2018/05/17 10:45:12');
INSERT INTO "news_post" (id_content,title,photo,comments,views,authors,published,published_date)
VALUES (5,'ipsum ac mi','purus.',124,55,1,FALSE,'2018/04/27 10:45:12');
INSERT INTO "news_post" (id_content,title,photo,comments,views,authors,published,published_date)
VALUES (1,'Nulla dignissim. Maecenas ornare egestas','facilisis',39,2,2,TRUE,'2018/11/17 10:45:12');
INSERT INTO "news_post" (id_content,title,photo,comments,views,authors,published,published_date)
VALUES (7,'turpis vitae purus gravida sagittis.','Nulla',42,22,5,TRUE,'2018/11/27 10:45:12');
INSERT INTO "news_post" (id_content,title,photo,comments,views,authors,published,published_date)
VALUES (11,'non, cursus non, egestas','viverra.',54,19,1,FALSE,'2018/06/17 10:45:12');

INSERT INTO "comment" (id_content,parent_comment,parent_news) VALUES (3,2,2);
INSERT INTO "comment" (id_content,parent_comment,parent_news) VALUES (18,7,8);
INSERT INTO "comment" (id_content,parent_comment,parent_news) VALUES (13,1,10);
INSERT INTO "comment" (id_content,parent_comment,parent_news) VALUES (15,7,9);

INSERT INTO "comment_creation" (id_comment,id_user) VALUES (3,9);
INSERT INTO "comment_creation" (id_comment,id_user) VALUES (18,10);
INSERT INTO "comment_creation" (id_comment,id_user) VALUES (13,5);
INSERT INTO "comment_creation" (id_comment,id_user) VALUES (15,4);

INSERT INTO "news_creation" (id_news,id_user,ready,approval_date) VALUES (4,2,TRUE,'2018/11/17 10:45:12');
INSERT INTO "news_creation" (id_news,id_user,ready,approval_date) VALUES (4,3,FALSE,null);
INSERT INTO "news_creation" (id_news,id_user,ready,approval_date) VALUES (4,1,TRUE,'2018/11/18 10:45:12');
INSERT INTO "news_creation" (id_news,id_user,ready,approval_date) VALUES (10,1,TRUE,'2018/05/17 10:45:12');
INSERT INTO "news_creation" (id_news,id_user,ready,approval_date) VALUES (8,8,TRUE,'2018/05/16 11:45:12');
INSERT INTO "news_creation" (id_news,id_user,ready,approval_date) VALUES (8,7,FALSE,null);
INSERT INTO "news_creation" (id_news,id_user,ready,approval_date) VALUES (2,5,TRUE,'2018/08/17 11:45:12');
INSERT INTO "news_creation" (id_news,id_user,ready,approval_date) VALUES (6,4,FALSE,null);
INSERT INTO "news_creation" (id_news,id_user,ready,approval_date) VALUES (9,3,FALSE,null);
INSERT INTO "news_creation" (id_news,id_user,ready,approval_date) VALUES (9,2,TRUE,'2018/08/10 11:45:12');
INSERT INTO "news_creation" (id_news,id_user,ready,approval_date) VALUES (9,9,FALSE,null);
INSERT INTO "news_creation" (id_news,id_user,ready,approval_date) VALUES (5,6,FALSE,null);
