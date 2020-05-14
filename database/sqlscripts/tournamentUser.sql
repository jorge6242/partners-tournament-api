-- Si da error con un constraint ejecutar este comando
--ALTER TABLE tournament_users DROP CONSTRAINT DF__tournamen__statu__42E1EEFE

ALTER TABLE tournament_users ALTER COLUMN status INTEGER;