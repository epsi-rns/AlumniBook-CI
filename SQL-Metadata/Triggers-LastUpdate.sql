SET TERM ^ ;

CREATE TRIGGER ModifiedAlumni FOR Alumni
ACTIVE BEFORE UPDATE POSITION 0
AS BEGIN 
  new.last_update='now';
END^

CREATE TRIGGER ModifiedOrganization FOR Organization
ACTIVE BEFORE UPDATE POSITION 0
AS BEGIN 
  new.last_update='now';
END^

CREATE TRIGGER ModifiedAOMap FOR AOMap
ACTIVE BEFORE UPDATE POSITION 0
AS BEGIN 
  new.last_update='now';
END^

SET TERM ; ^ 

/*----------------*/

SET TERM ^ ;

CREATE TRIGGER ModifiedOFields FOR OFields
ACTIVE AFTER INSERT OR UPDATE OR DELETE POSITION 0
AS DECLARE VARIABLE ID INTEGER;
BEGIN 
  ID = old.OID; 
  UPDATE Organization SET last_update='now' WHERE OID=:ID;  
END^

SET TERM ; ^ 

/*----------------*/
SET TERM ^ ;

CREATE TRIGGER ModifiedACommunities FOR ACommunities
ACTIVE AFTER INSERT OR UPDATE OR DELETE POSITION 0
AS DECLARE VARIABLE ID INTEGER;
BEGIN 
  ID = old.AID; 
  UPDATE Alumni SET last_update='now' WHERE AID=:ID;  
END^

CREATE TRIGGER ModifiedACompetencies FOR ACompetencies
ACTIVE AFTER INSERT OR UPDATE OR DELETE POSITION 0
AS DECLARE VARIABLE ID INTEGER;
BEGIN 
  ID = old.AID; 
  UPDATE Alumni SET last_update='now' WHERE AID=:ID;  
END^

CREATE TRIGGER ModifiedACertifications FOR ACertifications
ACTIVE AFTER INSERT OR UPDATE OR DELETE POSITION 0
AS DECLARE VARIABLE ID INTEGER;
BEGIN 
  ID = old.AID; 
  UPDATE Alumni SET last_update='now' WHERE AID=:ID;  
END^

CREATE TRIGGER ModifiedADegrees FOR ADegrees
ACTIVE AFTER INSERT OR UPDATE OR DELETE POSITION 0
AS DECLARE VARIABLE ID INTEGER;
BEGIN 
  ID = old.AID; 
  UPDATE Alumni SET last_update='now' WHERE AID=:ID;  
END^

CREATE TRIGGER ModifiedAExperiences FOR AExperiences
ACTIVE AFTER INSERT OR UPDATE OR DELETE POSITION 0
AS DECLARE VARIABLE ID INTEGER;
BEGIN 
  ID = old.AID; 
  UPDATE Alumni SET last_update='now' WHERE AID=:ID;  
END^

SET TERM ; ^ 
/*----------------*/
SET TERM ^ ;

CREATE TRIGGER ModifiedAdress FOR Address
ACTIVE AFTER INSERT OR UPDATE OR DELETE POSITION 0
AS DECLARE VARIABLE ID INTEGER;
BEGIN 
  ID = old.LID; 
  IF (old.LinkType='A') THEN
    UPDATE Alumni SET last_update='now' WHERE AID=:ID;  
  ELSE IF (old.LinkType='O') THEN
    UPDATE Organization SET last_update='now' WHERE OID=:ID;  
  ELSE IF (old.LinkType='M') THEN
    UPDATE AOMap SET last_update='now' WHERE MID=:ID;  
END^

CREATE TRIGGER ModifiedContact FOR Contacts
ACTIVE AFTER INSERT OR UPDATE OR DELETE POSITION 0
AS DECLARE VARIABLE ID INTEGER;
BEGIN 
  ID = old.LID; 
  IF (old.LinkType='A') THEN
    UPDATE Alumni SET last_update='now' WHERE AID=:ID;  
  ELSE IF (old.LinkType='O') THEN
    UPDATE Organization SET last_update='now' WHERE OID=:ID;  
  ELSE IF (old.LinkType='M') THEN
    UPDATE AOMap SET last_update='now' WHERE MID=:ID;  
END^

SET TERM ; ^ 
/*----------------*/