-- Table: destino

-- DROP TABLE destino;

CREATE TABLE destino
(
  id_destino serial NOT NULL,
  nome character varying(200) NOT NULL,
  sigla character varying(5) NOT NULL,
  pais character varying(3),
  CONSTRAINT pk_destino PRIMARY KEY (id_destino)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE destino
  OWNER TO postgres;
-- Table: telefone

-- DROP TABLE telefone;

CREATE TABLE telefone
(
  id_telefone serial NOT NULL,
  numero character varying(11) NOT NULL,
  ativo boolean NOT NULL DEFAULT false,
  id_usuario integer,
  codigo integer,
  CONSTRAINT pk_telefone PRIMARY KEY (id_telefone),
  CONSTRAINT fk_telefone_usuario FOREIGN KEY (id_usuario)
      REFERENCES usuario (id_usuario) MATCH Unknown
      ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT uk_telefone UNIQUE (numero)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE telefone
  OWNER TO postgres;
-- Table: usuario

-- DROP TABLE usuario;

CREATE TABLE usuario
(
  id_usuario serial NOT NULL,
  email character varying(200),
  senha character varying(100),
  CONSTRAINT pk_usuario PRIMARY KEY (id_usuario)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE usuario
  OWNER TO postgres;
-- Function: remove_acento(text)

-- DROP FUNCTION remove_acento(text);

CREATE OR REPLACE FUNCTION remove_acento(text)
  RETURNS text AS
$BODY$
SELECT TRANSLATE($1,'·‡„‚‰¡¿√¬ƒÈËÍÎ…» ÀÌÏÓÔÕÃŒœÛÚıÙˆ”“’‘÷˙˘˚¸⁄Ÿ€‹Ò—Á«ˇ˝›','aaaaaAAAAAeeeeEEEEiiiiIIIIoooooOOOOOuuuuUUUUnNcCyyY')
$BODY$
  LANGUAGE sql IMMUTABLE STRICT
  COST 100;
ALTER FUNCTION remove_acento(text)
  OWNER TO postgres;
