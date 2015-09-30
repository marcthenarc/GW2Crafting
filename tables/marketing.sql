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
-- Name: marketing; Type: TABLE; Schema: public; Owner: <OWNER>; Tablespace: 
--

CREATE TABLE marketing (
    id integer NOT NULL,
    type text,
    index integer
);


ALTER TABLE public.marketing OWNER TO <OWNER>;

--
-- Name: marketing_id_seq; Type: SEQUENCE; Schema: public; Owner: <OWNER>
--

CREATE SEQUENCE marketing_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.marketing_id_seq OWNER TO <OWNER>;

--
-- Name: marketing_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: <OWNER>
--

ALTER SEQUENCE marketing_id_seq OWNED BY marketing.id;


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: <OWNER>
--

ALTER TABLE ONLY marketing ALTER COLUMN id SET DEFAULT nextval('marketing_id_seq'::regclass);


--
-- Name: marketing_pkey; Type: CONSTRAINT; Schema: public; Owner: <OWNER>; Tablespace: 
--

ALTER TABLE ONLY marketing
    ADD CONSTRAINT marketing_pkey PRIMARY KEY (id);


--
-- PostgreSQL database dump complete
--

