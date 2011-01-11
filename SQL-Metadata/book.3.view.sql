/* Jangan lupa client dialect disesuaikan (INTEGER atau INT64) */

CREATE GENERATOR Common_ID;
CREATE GENERATOR Detail_ID;

SET GENERATOR Common_ID to 100;
SET GENERATOR Detail_ID to 100;

CREATE VIEW Next_ID ( New_ID ) AS
select Gen_ID(Common_ID, 1) from rdb$database;

CREATE VIEW Next_DID ( New_ID ) AS
select Gen_ID(Detail_ID, 1) from rdb$database;







