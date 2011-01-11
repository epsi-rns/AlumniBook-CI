select * from organization
where OID in (2440,2450,2456,2479,2488,2508,2511,2537,2548)

1. Find OID dari branch

2. Check OField
select * from ofields
where OID in

3. Find MID di AOMAP
select * from AOMAP
where OID in

3. update Address
select * from Address
where LinkType='O' 
and LID in

4. update Contacts
select * from Contacts
where LinkType='O' 
and LID in

5. update map
update aomap 
OID = headoffice
where OID in

6. delete org
delete organization
where OID in
/* ======================= */
If OField then exit;

A=GenID
select Gen_ID(Detail_ID, 1) from rdb$database
SELECT New_ID FROM NextD_ID



/* ======================= */
SET TERM ^ ;

CREATE PROCEDURE Pindah 
AS
  DECLARE VARIABLE MID	INTEGER;
  DECLARE VARIABLE AID	INTEGER;
  DECLARE VARIABLE OID	INTEGER;
  DECLARE VARIABLE LID	INTEGER;
  DECLARE VARIABLE DID	INTEGER;
  DECLARE VARIABLE FieldCount	INTEGER;
  DECLARE VARIABLE HeadOfficeID	INTEGER;
BEGIN
  HeadOfficeID = 100;
 
  FOR SELECT MID, AID, OID FROM AOMap
  WHERE OID IN (2667)
  INTO :MID, :AID, :OID DO
  BEGIN
    /* check for field */
    SELECT COUNT(*) FROM OFields
    WHERE OID=:OID INTO :FieldCount;

    IF (FieldCount>1) THEN EXIT;

    /* move address */
    FOR SELECT DID, LID FROM Address
    WHERE (LinkType='O') AND (LID=:OID)
    INTO :DID, :LID DO 
    BEGIN
      /* Change to mapping */
      UPDATE Address SET LID=:MID WHERE DID=:DID;
      UPDATE Address SET LinkType='M' WHERE DID=:DID;
    END

    /* move contacts */
    FOR SELECT DID, LID FROM Contacts
    WHERE (LinkType='O') AND (LID=:OID)
    INTO :DID, :LID DO 
    BEGIN
      /* Change to mapping */
      UPDATE Contacts SET LID=:MID WHERE DID=:DID;
      UPDATE Contacts SET LinkType='M' WHERE DID=:DID;
    END

    /* move map */
    UPDATE AOMap SET OID = :HeadOfficeID WHERE MID= :MID;


    /* delete branch organization */
    DELETE FROM Organization WHERE OID=:OID;

    /* Finally */
  END
END^

SET TERM ; ^
/* ======================= */
EXCEUTE PROCEDURE Pindah;
