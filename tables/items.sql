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
-- Name: items; Type: TABLE; Schema: public; Owner: <OWNER>; Tablespace: 
--

CREATE TABLE items (
    id integer NOT NULL,
    json text,
    name_en text,
    name_fr text
);


ALTER TABLE public.items OWNER TO <OWNER>;

--
-- Name: items_json_seq; Type: SEQUENCE; Schema: public; Owner: <OWNER>
--

CREATE SEQUENCE items_json_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.items_json_seq OWNER TO <OWNER>;

--
-- Name: items_json_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: <OWNER>
--

ALTER SEQUENCE items_json_seq OWNED BY items.json;


--
-- Name: items_id_index; Type: INDEX; Schema: public; Owner: <OWNER>; Tablespace: 
--

CREATE UNIQUE INDEX items_id_index ON items USING btree (id);


--
-- PostgreSQL database dump complete
--

