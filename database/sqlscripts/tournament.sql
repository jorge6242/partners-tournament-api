-- Si da error con un constraint ejecutar este comando
--ALTER TABLE tournaments DROP CONSTRAINT DF__tournamen__descr__19AACF41;


-- ALTER TABLE tournaments ALTER COLUMN template_welcome_mail nvarchar(4000) NULL;
-- ALTER TABLE tournaments ALTER COLUMN template_confirmation_mail nvarchar(4000) NULL;
-- ALTER TABLE tournaments ALTER COLUMN description_price nvarchar(4000) NULL;
-- ALTER TABLE tournaments ALTER COLUMN description_details nvarchar(4000) NULL;
-- ALTER TABLE tournaments ALTER COLUMN user_comments nvarchar(4000) NULL;

-- ALTER TABLE tournaments ADD paypal_id VARCHAR(255) NULL;

ALTER TABLE tournaments ADD booking_type INT NULL;