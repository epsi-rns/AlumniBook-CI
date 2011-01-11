SET TERM ^ ;

CREATE PROCEDURE RefContactList (LID INTEGER, LinkType CHAR)
RETURNS (
  ContactType	VARCHAR(25),
  Contacts	VARCHAR(200)
)
AS
  DECLARE VARIABLE CTID	INTEGER;
  DECLARE VARIABLE Contact VARCHAR(50);
BEGIN
  FOR SELECT DISTINCT C.CTID, CT.ContactType
      FROM Contacts C
	INNER JOIN ContactType CT ON (C.CTID = CT.CTID)
      WHERE LID=:LID AND LinkType= :LinkType
  INTO :CTID, :ContactType
  DO
  BEGIN
    Contacts = '';
    FOR SELECT Contact
	FROM Contacts
	WHERE ((LID = :LID) AND (CTID = :CTID) AND (LinkType = :LinkType))
    INTO :Contact
    DO EXECUTE PROCEDURE AddComma :Contacts, :Contact RETURNING_VALUES :Contacts;

    SUSPEND;
  END
END^

SET TERM ; ^
/* ======================= */
SET TERM ^ ;

CREATE PROCEDURE RefContactList (LID INTEGER, LinkType CHAR)
RETURNS (
  ContactType	VARCHAR(25),
  Contacts	VARCHAR(100)
) AS
  DECLARE VARIABLE CTID	INTEGER;
  DECLARE VARIABLE Contact VARCHAR(35);
BEGIN
  FOR SELECT CTID, ContactType FROM ContactType 
  INTO :CTID, :ContactType
  DO BEGIN
    Contacts = '';
    FOR SELECT Contact FROM Contacts
	WHERE ((LID = :LID) AND (CTID = :CTID) AND (LinkType = :LinkType))
    INTO :Contact 
    DO EXECUTE PROCEDURE AddComma :Contacts, :Contact RETURNING_VALUES :Contacts;

    IF (Contacts<>'') THEN SUSPEND;
  END
END^

SET TERM ; ^

/* ======================= */
SET TERM ^ ;

CREATE PROCEDURE ContactLists (LinkType CHAR)
RETURNS (
  LID	INTEGER,
  ContactType	VARCHAR(25),
  Contacts	VARCHAR(100)
) AS
  DECLARE VARIABLE CTID	INTEGER;
  DECLARE VARIABLE Contact VARCHAR(35);
BEGIN
  FOR SELECT CTID, ContactType FROM ContactType 
  INTO :CTID, :ContactType
  DO BEGIN
    Contacts = '';
    FOR SELECT LID, Contact FROM Contacts
	WHERE ((CTID = :CTID) AND (LinkType = :LinkType))
    INTO :LID, :Contact 
    DO BEGIN

      EXECUTE PROCEDURE AddComma :Contacts, :Contact RETURNING_VALUES :Contacts;

      SUSPEND;
    END

  END
END^

SET TERM ; ^
/* ======================= */

SET TERM ^ ;

RECREATE PROCEDURE ContactLists (LinkType CHAR)
RETURNS (
  LID	INTEGER,
  ContactType	VARCHAR(25),
  Contacts	VARCHAR(100)
) AS
  DECLARE VARIABLE CTID	INTEGER;
  DECLARE VARIABLE Contact VARCHAR(35);
BEGIN
  FOR SELECT DISTINCT LID FROM Contacts INTO :LID DO 
    FOR SELECT ContactType, Contacts 
    FROM RefContactList (:LID, :LinkType)
    INTO :ContactType, :Contacts
    DO SUSPEND;
END^

SET TERM ; ^