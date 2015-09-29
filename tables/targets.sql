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
-- Name: targets; Type: TABLE; Schema: public; Owner: narc; Tablespace: 
--

CREATE TABLE targets (
    id integer NOT NULL,
    target integer,
    ingredient integer,
    amount integer,
    craft boolean
);


ALTER TABLE public.targets OWNER TO narc;

--
-- Name: targets_id_seq; Type: SEQUENCE; Schema: public; Owner: narc
--

CREATE SEQUENCE targets_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.targets_id_seq OWNER TO narc;

--
-- Name: targets_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: narc
--

ALTER SEQUENCE targets_id_seq OWNED BY targets.id;


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: narc
--

ALTER TABLE ONLY targets ALTER COLUMN id SET DEFAULT nextval('targets_id_seq'::regclass);


--
-- PostgreSQL database dump complete
--

