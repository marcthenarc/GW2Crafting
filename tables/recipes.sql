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
-- Name: recipes; Type: TABLE; Schema: public; Owner: <OWNER>; Tablespace: 
--

CREATE TABLE recipes (
    id integer NOT NULL,
    json text,
    output integer
);


ALTER TABLE public.recipes OWNER TO <OWNER>;

--
-- Name: recipies_id_seq; Type: SEQUENCE; Schema: public; Owner: <OWNER>
--

CREATE SEQUENCE recipies_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.recipies_id_seq OWNER TO <OWNER>;

--
-- Name: recipies_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: <OWNER>
--

ALTER SEQUENCE recipies_id_seq OWNED BY recipes.id;


--
-- Name: recipies_pkey; Type: CONSTRAINT; Schema: public; Owner: <OWNER>; Tablespace: 
--

ALTER TABLE ONLY recipes
    ADD CONSTRAINT recipies_pkey PRIMARY KEY (id);


--
-- PostgreSQL database dump complete
--

