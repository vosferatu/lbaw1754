DROP TABLE news_creation;
DROP TABLE comment_creation;
DROP TABLE content_report;
DROP TABLE downvotes;
DROP TABLE upvotes;
DROP TABLE saves;
DROP TABLE verified;
DROP TABLE inactive;
DROP TABLE suspended;
DROP TABLE banned;
DROP TABLE kicked;
DROP TABLE moderator;
DROP TABLE administrator;
DROP TABLE user_subscribes;
DROP TABLE user_report;
DROP TABLE tags_blocked;
DROP TABLE tags_subscribed;
DROP TABLE comment;
DROP TABLE news_post;
DROP TABLE content;
DROP TABLE tags ;
DROP TABLE "user";
DROP FUNCTION news_post_upvote();
DROP FUNCTION news_post_downvote();
DROP FUNCTION check_if_news_is_published();
DROP FUNCTION set_user_published();
DROP FUNCTION set_news_publish_date();

CREATE TABLE "user" (
   id SERIAL NOT NULL,
   username text NOT NULL,
   password text NOT NULL,
   email text NOT NULL,
   nome text,
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

CREATE INDEX user_id ON "user" USING HASH (id);	


-- TRIGGERS and UDFs
   
CREATE FUNCTION news_post_upvote() RETURNS TRIGGER AS
$BODY$
BEGIN
 UPDATE content SET votes = votes + 1 FROM content 
   WHERE content.id = NEW.id_content;
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
 UPDATE content SET votes = votes - 1 FROM content 
   WHERE content.id = NEW.id_content;
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
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER news_publish_date
 AFTER UPDATE ON news_creation
 FOR EACH ROW
   EXECUTE PROCEDURE set_news_publish_date();	
