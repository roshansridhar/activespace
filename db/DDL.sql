#postgres

CREATE TABLE public.userinfo
(
    user_id SERIAL,
    creation_timestamp timestamp without time zone,
    email_id character varying(100) COLLATE pg_catalog."default" NOT NULL,
    username character varying(40) COLLATE pg_catalog."default" NOT NULL,
    user_password character varying(30) COLLATE pg_catalog."default" NOT NULL,
    first_name character(255) COLLATE pg_catalog."default" NOT NULL,
    last_name character(255) COLLATE pg_catalog."default" NOT NULL,
    phone integer NOT NULL,
    gender character(10) COLLATE pg_catalog."default" NOT NULL,
    date_of_birth date NOT NULL,
    picture_medium bytea,
    update_timestamp timestamp without time zone,
    last_log_in timestamp without time zone,
    about_me text COLLATE pg_catalog."default",
    interests text COLLATE pg_catalog."default",
    network_visibility integer NOT NULL,
    location_lat real,
    location_lng real,
    CONSTRAINT userinfo_pkey PRIMARY KEY (user_id)
);

CREATE TABLE public.friendrelation
(
    user_one_id integer NOT NULL,
    user_two_id integer NOT NULL,
    friendship_status integer NOT NULL,
    visibility_status integer NOT NULL,
    action_user_id integer NOT NULL,
    request_time timestamp without time zone,
    action_taken_time timestamp without time zone,
    CONSTRAINT fk_friendrelation_userinfo FOREIGN KEY (user_one_id)
        REFERENCES public.userinfo (user_id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT friendrelation_action_user_id_fkey FOREIGN KEY (action_user_id)
        REFERENCES public.userinfo (user_id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT friendrelation_user_two_id_fkey FOREIGN KEY (user_two_id)
        REFERENCES public.userinfo (user_id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

CREATE TABLE public.multimedia
(
    media_id integer NOT NULL,
    user_id integer NOT NULL DEFAULT nextval('multimediaposts_user_id_seq'::regclass),
    post_time timestamp without time zone,
    content bytea NOT NULL,
    description text COLLATE pg_catalog."default",
    category integer NOT NULL,
    location_lat real,
    location_lng real,
    CONSTRAINT fk_multimediaposts_userinfo FOREIGN KEY (user_id)
        REFERENCES public.userinfo (user_id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

CREATE TABLE public.diaryentry
(
    entry text COLLATE pg_catalog."default",
    diary_id integer NOT NULL DEFAULT nextval('diaryentry_diary_id_seq'::regclass),
    media bytea NOT NULL,
    user_id integer NOT NULL,
    diarytime timestamp without time zone NOT NULL,
    like_id integer,
    comment_id integer,
    location_lat real,
    location_lng real,
    title character varying(100) COLLATE pg_catalog."default" NOT NULL,
    CONSTRAINT diaryentry_pkey PRIMARY KEY (diary_id),
    CONSTRAINT diaryentry_user_id_fkey FOREIGN KEY (user_id)
        REFERENCES public.userinfo (user_id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE,
-- add the following foreign key constraint after creating the diary_comments table below 
        CONSTRAINT diaryentry_comment_id_fkey FOREIGN KEY (comment_id)
        REFERENCES public.diary_comments (comment_id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE

);

CREATE TABLE public.diary_comments
(
    comment_id SERIAL,
    comment_entry text COLLATE pg_catalog."default",
    diary_id integer,
    comment_time timestamp,
    user_id integer NOT NULL,
    CONSTRAINT diary_comments_pkey PRIMARY KEY (comment_id),
    CONSTRAINT diary_comments_diary_id_fkey FOREIGN KEY (diary_id)
        REFERENCES public.diaryentry (diary_id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT diaryentry_user_id_fkey FOREIGN KEY (user_id)
        REFERENCES public.userinfo (user_id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE

);

CREATE TABLE public.diary_likes
(
    diary_id integer NOT NULL,
    user_id integer NOT NULL,
    like_time timestamp,
    CONSTRAINT diary_likes_pkey PRIMARY KEY (diary_id, user_id),
    CONSTRAINT diary_likes_user_id_fkey FOREIGN KEY (user_id)
        REFERENCES public.userinfo (user_id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE

);

CREATE TABLE public.credentials
(
    user_id integer NOT NULL,
    password character varying(100) COLLATE pg_catalog."default",
    CONSTRAINT credentials_user_id_fkey FOREIGN KEY (user_id)
        REFERENCES public.userinfo (user_id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

CREATE TABLE public.events
(
    event_id integer NOT NULL DEFAULT nextval('events_event_id_seq'::regclass),
    description text COLLATE pg_catalog."default",
    event_time timestamp without time zone,
    location_lat real,
    location_lng real,
    CONSTRAINT events_pkey PRIMARY KEY (event_id)
);

CREATE TABLE public.event_members
(
    event_id integer NOT NULL,
    user_id integer NOT NULL,
    invited_by integer NOT NULL,
    invite_date timestamp without time zone,
    status integer,
    CONSTRAINT event_members_pkey PRIMARY KEY (event_id, user_id, invited_by),
    CONSTRAINT event_members_event_id_fkey FOREIGN KEY (event_id)
        REFERENCES public.events (event_id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT event_members_invited_by_fkey FOREIGN KEY (invited_by)
        REFERENCES public.userinfo (user_id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT event_members_user_id_fkey FOREIGN KEY (user_id)
        REFERENCES public.userinfo (user_id) MATCH SIMPLE
        ON UPDATE CASCADE
        ON DELETE CASCADE
);