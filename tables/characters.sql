--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: characters; Type: TABLE; Schema: public; Owner: <OWNER>; Tablespace: 
--

CREATE TABLE characters (
    id integer NOT NULL,
    json text,
    name text
);


ALTER TABLE public.characters OWNER TO <OWNER>;

--
-- Name: characters_id_seq; Type: SEQUENCE; Schema: public; Owner: <OWNER>
--

CREATE SEQUENCE characters_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.characters_id_seq OWNER TO <OWNER>;

--
-- Name: characters_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: <OWNER>
--

ALTER SEQUENCE characters_id_seq OWNED BY characters.id;


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: <OWNER>
--

ALTER TABLE ONLY characters ALTER COLUMN id SET DEFAULT nextval('characters_id_seq'::regclass);


--
-- Name: characters_pkey; Type: CONSTRAINT; Schema: public; Owner: <OWNER>; Tablespace: 
--

ALTER TABLE ONLY characters
    ADD CONSTRAINT characters_pkey PRIMARY KEY (id);


--
-- PostgreSQL database dump complete
--

