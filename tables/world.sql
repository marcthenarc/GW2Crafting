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
-- Name: world; Type: TABLE; Schema: public; Owner: <OWNER>; Tablespace: 
--

CREATE TABLE world (
    name text,
    completed integer
);


ALTER TABLE public.world OWNER TO <OWNER>;

--
-- PostgreSQL database dump complete
--

