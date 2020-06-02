-- Si da error con un constraint ejecutar este comando
--ALTER TABLE users DROP CONSTRAINT DF__users__descr__19AACF41;

--ALTER TABLE users ADD new_user INT NULL;


ALTER TABLE users ADD confirmation_link VARCHAR(255) NULL;
ALTER TABLE users ADD dateconfirmed DATE NULL;
ALTER TABLE users ADD token VARCHAR(255) NULL;