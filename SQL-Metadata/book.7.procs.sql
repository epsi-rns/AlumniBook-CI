/* ======================= */
SET TERM ^ ;

CREATE PROCEDURE AddComma (SIn VARCHAR(140), SF VARCHAR(50))
RETURNS ( SOut VARCHAR(140) ) 
AS
BEGIN
  IF (SF IS NOT NULL) THEN 
  BEGIN
    IF ((SIn <> '')) THEN Sin = SIn || ', ';
    SOut = SIn || SF;
  END
  ELSE SOut = SIn;

  SUSPEND;
END^

SET TERM ; ^

/* ======================= */
SET TERM ^ ;

CREATE PROCEDURE FullContactValues (LinkType CHAR)
RETURNS (
  LID	INTEGER,
  ContactType	VARCHAR(25),
  Contacts	VARCHAR(100)
)
AS
  DECLARE VARIABLE CTID	INTEGER;
  DECLARE VARIABLE Contact VARCHAR(35);
BEGIN
  FOR SELECT DISTINCT
	C.LID, C.CTID, CT.ContactType
      FROM Contacts C
	INNER JOIN ContactType CT ON (C.CTID = CT.CTID)
      WHERE LinkType= :LinkType
  INTO
    :LID, :CTID, :ContactType
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
CREATE PROCEDURE SplitContact (LinkType Char(1))
RETURNS (
    LID		INTEGER,
    HP		VARCHAR(100),	/* 3 */
    Phone	VARCHAR(100),	/* 4 */
    Fax		VARCHAR(100),	/* 6 */
    email	VARCHAR(100),	/* 8 */
    website	VARCHAR(100)	/* 9 */
) AS
  DECLARE VARIABLE CTID	INTEGER;
  DECLARE VARIABLE Contact VARCHAR(35);
BEGIN
  FOR SELECT DISTINCT LID FROM Contacts
      WHERE LinkType= :LinkType
  INTO :LID DO
  BEGIN
    HP = ''; Phone =''; Fax = ''; email=''; website='';

    FOR SELECT Contact, CTID FROM Contacts 
      WHERE (LID= :LID)
    INTO :Contact, :CTID DO
    IF (Contact IS NOT NULL) THEN
      IF (CTID=3) THEN EXECUTE PROCEDURE AddComma :HP, :Contact RETURNING_VALUES :HP;
      ELSE IF (CTID=4) THEN EXECUTE PROCEDURE AddComma :Phone, :Contact RETURNING_VALUES :Phone;
      ELSE IF (CTID=6) THEN EXECUTE PROCEDURE AddComma :Fax, :Contact RETURNING_VALUES :Fax;
      ELSE IF (CTID=8) THEN EXECUTE PROCEDURE AddComma :email, :Contact RETURNING_VALUES :email;
      ELSE IF (CTID=9) THEN EXECUTE PROCEDURE AddComma :website, :Contact RETURNING_VALUES :website;
      ELSE BREAK;

    SUSPEND;
  END
END^
SET TERM ; ^

/* ======================= */

SELECT
  A.AID, C.CID, FN.Name, 
  NC.LinkType, NC.ContactType, NC.Contacts,
  C.Community, FA.Address, FA.Region
FROM Alumni A
  INNER JOIN FullName FN ON (A.AID = FN.AID)
  LEFT JOIN FullCommunityName C ON (A.AID = C.AID)
  LEFT JOIN NormalContacts NC ON (A.AID = NC.LID)
  LEFT JOIN FullAddress FA ON (A.AID = FA.LID)
WHERE (NC.LinkType = 'A') OR (NC.LinkType IS NULL) OR (FA.LinkType = 'A') OR (FA.LinkType IS NULL)



SELECT ct.ContactType, c.* FROM Contacts c
INNER JOIN ContactType ct ON (c.ctid = ct.ctid)
WHERE c.LinkType = 'O' AND c.LID=25