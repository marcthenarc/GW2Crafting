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
-- Name: inventory; Type: TABLE; Schema: public; Owner: <OWNER>; Tablespace: 
--

CREATE TABLE inventory (
    id integer NOT NULL,
    amount integer,
    diff integer
);


ALTER TABLE public.inventory OWNER TO <OWNER>;

--
-- Name: inventaire_id_key; Type: CONSTRAINT; Schema: public; Owner: <OWNER>; Tablespace: 
--

ALTER TABLE ONLY inventory
    ADD CONSTRAINT inventaire_id_key UNIQUE (id);


--
-- PostgreSQL database dump complete
--

