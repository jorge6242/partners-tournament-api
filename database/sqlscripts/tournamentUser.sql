-- Si da error con un constraint ejecutar este comando
--ALTER TABLE tournament_users DROP CONSTRAINT DF__tournamen__statu__42E1EEFE

--ALTER TABLE tournament_users ALTER COLUMN status INTEGER;

-- ALTER TABLE tournament_users ADD nro_comprobante varchar(255) NULL;
-- ALTER TABLE tournament_users ADD canal_pago varchar(255) NULL;
-- ALTER TABLE tournament_users ADD fec_pago datetime NULL;

ALTER TABLE tournament_users ADD winner INT NOT NULL DEFAULT(0);
ALTER TABLE tournament_users ADD fec_winnner datetime NULL;