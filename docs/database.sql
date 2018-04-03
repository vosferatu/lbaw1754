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
	name text NOT NULL,
	frequency Integer,
    CONSTRAINT frequency_positive CHECK ((frequency >= 0))
);
 
 CREATE TABLE tags_subscribed (
	tag_name text NOT NULL,
	id Integer NOT NULL
);
 
 CREATE TABLE tags_blocked (
	tag_name text NOT NULL,
	id Integer NOT NULL
);
 
 CREATE TABLE user_report (
	id_reported text NOT NULL,
	id_informer text NOT NULL
);
 
 CREATE TABLE user_subscribes (
	id_followed text NOT NULL,
	id_follower text NOT NULL
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
	id_user Integer NOT NULL,
);
 
 CREATE TABLE suspended (
	id_user Integer NOT NULL,
	days Integer NOT NULL,
    CONSTRAINT days_positive CHECK ((days > 0))
);
 
 CREATE TABLE inactive (
	id_user Integer NOT NULL,
	deletion_date TIMESTAMP WITH TIME zone DEFAULT now() NOT NULL,
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
	"text" NOT NULL,
	created TIMESTAMP WITH TIME zone DEFAULT now(),
	
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
	published_date TIMESTAMP WITH TIME,
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
	id_content Integer NOT NULL,
	parent_comment Integer NOT NULL
);
 
 CREATE TABLE news_creation (
	id_news Integer NOT NULL,
	id_user Integer NOT NULL
);
 
 -- Primary Keys and Uniques
 
 
ALTER TABLE ONLY "user"
    ADD CONSTRAINT user_pkey PRIMARY KEY (id);
 
ALTER TABLE ONLY "user"
    ADD CONSTRAINT user_ukey_username UNIQUE (username);
	
ALTER TABLE ONLY "user"
    ADD CONSTRAINT user_ukey_password UNIQUE (password);
	
ALTER TABLE ONLY "user"
    ADD CONSTRAINT user_ukey_email UNIQUE (email);
 
ALTER TABLE ONLY tags
    ADD CONSTRAINT tags_pkey PRIMARY KEY (name);
 
ALTER TABLE ONLY tags_subscribed
    ADD CONSTRAINT tags_subscribed_pkey PRIMARY KEY (tag_name, id);
 
ALTER TABLE ONLY tags_blocked
    ADD CONSTRAINT tags_blocked_pkey PRIMARY KEY (tag_name, id);
 
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
 
 -- Foreign Keys
 
ALTER TABLE ONLY tags_subscribed
    ADD CONSTRAINT tags_subscribed_tags_fkey FOREIGN KEY (tag_name) REFERENCES tags(name) ON UPDATE CASCADE;
 
ALTER TABLE ONLY tags_subscribed
    ADD CONSTRAINT tags_subscribed_user_fkey FOREIGN KEY (id) REFERENCES "user"(id) ON UPDATE CASCADE;
	
ALTER TABLE ONLY tags_blocked
    ADD CONSTRAINT tags_blocked_tags_fkey FOREIGN KEY (tag_name) REFERENCES tags(name) ON UPDATE CASCADE;
	
ALTER TABLE ONLY tags_blocked
    ADD CONSTRAINT tags_blocked_user_fkey FOREIGN KEY (id) REFERENCES "user"(id) ON UPDATE CASCADE;
	
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
    ADD CONSTRAINT saves_user_fkey FOREIGN KEY (id_user) REFERENCES "user"(id) ON UPDATE CASCADE
	
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