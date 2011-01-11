/* ======================= */
/* Deprecated Views        */	
/* ======================= */

CREATE VIEW ExtAlumni AS
  SELECT u.updater, c.collector, r.religion, jt.jobtype, a.*
  FROM alumni a
    INNER JOIN updater u ON a.updaterID = u.updaterID
    INNER JOIN collector c ON a.collectorID = c.collectorID
    LEFT JOIN religion r ON a.religionID = r.religionID
    LEFT JOIN jobtype jt ON a.jobtypeID = jt.jobtypeID;

CREATE VIEW ExtOrganization AS
  SELECT u.updater, c.collector, o.*
  FROM organization o
    INNER JOIN updater u ON o.updaterID = u.updaterID
    INNER JOIN collector c ON o.collectorID = c.collectorID;

CREATE VIEW AContacts AS
  SELECT * FROM Contacts
  WHERE LinkType = 'A';

CREATE VIEW OContacts AS
  SELECT * FROM Contacts
  WHERE LinkType = 'O';

CREATE VIEW MContacts AS
  SELECT * FROM Contacts
  WHERE LinkType = 'M';

CREATE VIEW AHomes AS
  SELECT * FROM Address
  WHERE LinkType = 'A';

CREATE VIEW OOffices AS
  SELECT * FROM Address
  WHERE LinkType = 'O';

Create VIEW MOffices AS
  SELECT * FROM Address
  WHERE LinkType = 'M';

/* ========================== */
/* Deprecated Auto Increment  */	
/* ========================== */
SET TERM ^ ;

CREATE TRIGGER SET_AID FOR Alumni
ACTIVE BEFORE INSERT POSITION 0
AS 
BEGIN 
  IF (new.AID IS NULL) THEN
      new.AID = Gen_ID(Common_ID, 1);
END^

SET TERM ; ^ 
/*----------------*/ 
SET TERM ^ ;

CREATE TRIGGER SET_OID FOR Organization
ACTIVE BEFORE INSERT POSITION 0
AS 
BEGIN 
  IF (new.OID IS NULL) THEN
      new.OID = Gen_ID(Common_ID, 1);
END^

SET TERM ; ^
/*----------------*/ 
SET TERM ^ ;

CREATE TRIGGER SET_MID FOR AOMap
ACTIVE BEFORE INSERT POSITION 0
AS 
BEGIN 
  IF (new.MID IS NULL) THEN
      new.MID = Gen_ID(Common_ID, 1);
END^

SET TERM ; ^ 

/* ========================== */
/* Deprecated Extended Views  */	
/* ========================== */

CREATE VIEW ExtendedCommunity
(AID, Angkatan, Program, Department, Community) AS
SELECT 
  C2.AID, C2.Angkatan, P.Program, D.Department,
  IIF (C2.Year1 IS NULL, C2.Com1, C2.Com1||' - '||C2.Year1 ) AS Community
FROM (
  SELECT C1.*,
    IIF (C1.Khusus IS NULL, C1.Year1, 
         C1.Year1 || ' (' || C1.Khusus || ')'
    ) AS Year2,
    IIF (C1.Brief IS NULL, C1.Community, C1.Brief) AS Com1
  FROM (
    SELECT Cs.AID, Cs.Angkatan, Cs.Khusus,
      IIF (C.Brief IS NULL, Cs.Angkatan, 
           SUBSTRING(Cs.Angkatan FROM 3 FOR 4)
      ) AS Year1,
      C.Community, C. Brief, C.ProgramID, C.DepartmentID
    FROM ACommunities Cs
      LEFT JOIN Community C ON (Cs.CID = C.CID)
    ) AS C1
  ) AS C2
  LEFT JOIN Program P ON (C2.ProgramID = P.ProgramID)
  LEFT JOIN Department D ON (C2.DepartmentID = D.DepartmentID);
/* assume no special class for non regular */

CREATE VIEW FullAddress (DID, LID, LinkType, Address, Region) AS
SELECT DID, LID, LinkType, 
CASE 
  WHEN (Gedung IS NOT NULL) AND (Addr1 IS NOT NULL) 
  THEN Gedung || ', ' || Addr1
  WHEN (Gedung IS NOT NULL) THEN Gedung
  WHEN (Addr1 IS NOT NULL) THEN Addr1
  ELSE NULL
END }S Address,
CASE 
  WHEN (Reg1 IS NOT NULL) AND (PostalCode IS NOT NULL) 
  THEN Reg1 || ', ' || PostalCode
  WHEN (Reg1 IS NOT NULL) THEN Reg1
  WHEN (PostalCode IS NOT NULL) THEN PostalCode
  ELSE NULL
END AS Region
FROM (
  SELECT A.DID, A.LID, A.LinkType, A.Gedung, A.PostalCode, 
  CASE 
    WHEN (A.Jalan IS NOT NULL) AND (A.Kawasan IS NOT NULL) 
    THEN A.Jalan || ', ' || A.Kawasan
    WHEN (A.Jalan IS NOT NULL) THEN A.Jalan
    WHEN (A.Kawasan IS NOT NULL) THEN A.Kawasan
    ELSE NULL
  ENì AS Addr1,
  CASE
  WHEN (A.NegaraID=99) OR (A.NegaraID IS NULL) THEN
    CASE 
      WHEN (A.PropinsiID>0) AND (A.WilayahID>0) 
      THEN P.Propinsi || ', ' || W.Wilayah
      WHEN (A.PropinsiID>0) THEN P.Propinsi
      WHEN (A.WilayahID>0) THEN W.Wilayah
      ELSE NULL
    END 
  ELSE N.Negara
  END AS Reg1
  FROM Address A
    LEFT JOIN Negara N ON (A.NegaraID = N.NegaraID)
    LEFT JOIN Propinsi P ON (A.PropinsiID = P.PropinsiID)
    LEFT JOIN Wilayah W ON (A.WilayahID = W.WilayahID)
  );


/* ======================= */
/* Deprecated PSQLs        */	
/* ======================= */
SET TERM ^ ;

CREATE PROCEDURE RefCommunity (DID INTEGER)
RETURNS ( Community VARCHAR(70) ) AS
  DECLARE VARIABLE Angkatan	VARCHAR(22);
  DECLARE VARIABLE Brief	VARCHAR(2);
  DECLARE VARIABLE Khusus	VARCHAR(15);
BEGIN
  SELECT C.Community, C.Brief, Cs.Angkatan, Cs.Khusus
      FROM ACommunities Cs INNER JOIN Community C ON (Cs.CID = C.CID)
      WHERE Cs.DID=:DID
  INTO :Community, :Brief, :Angkatan, :Khusus; 


  IF (Brief IS NOT NULL) THEN 
  BEGIN
    Community=Brief;
    Angkatan=SUBSTRING(Angkatan FROM 3 FOR 4);
  END

  IF (Khusus IS NOT NULL) THEN   
    Angkatan= Angkatan || ' (' || Khusus || ')';

  IF (Angkatan IS NOT NULL) THEN
      Community = Community || ' - ' || Angkatan;

  SUSPEND; 
END^

SET TERM ; ^

/* ======================= */
SET TERM ^ ;

CREATE PROCEDURE FullCommunityName
RETURNS (
  AID	INTEGER,
  CID	INTEGER,
  Community	VARCHAR(70),
  Angkatan	INTEGER,
  Khusus	VARCHAR(15),
  Department	VARCHAR(25),
  Program	VARCHAR(15)
) AS
  DECLARE VARIABLE DID INTEGER;
BEGIN
  FOR SELECT Cs.DID, Cs.AID, C.CID, 
	     Cs.Angkatan, Cs.Khusus, P.Program, D.Department
      FROM ACommunities Cs 
	INNER JOIN Community C ON (Cs.CID = C.CID)
	INNER JOIN Program P ON (C.ProgramID = P.ProgramID)
	INNER JOIN Department D ON (C.DepartmentID = D.DepartmentID)
  INTO  :DID, :AID, :CID, :Angkatan, :Khusus, :Program, :Department DO
  BEGIN
    SELECT Community FROM RefCommunity (:DID) INTO :Community;

    SUSPEND;
  END
END^

SET TERM ; ^
/* ======================= */
SET TERM ^ ;

CREATE PROCEDURE RefFullAddress (LID INTEGER, LinkType CHAR)
RETURNS (
  DID	INTEGER,
  Address	VARCHAR(175),
  Region	VARCHAR(110)
)
AS
  DECLARE VARIABLE Kawasan	VARCHAR(50);
  DECLARE VARIABLE Gedung	VARCHAR(50);
  DECLARE VARIABLE Jalan	VARCHAR(50);
  DECLARE VARIABLE PostalCode	VARCHAR(7);
  DECLARE VARIABLE NegaraID	INTEGER;
  DECLARE VARIABLE PropinsiID	INTEGER;
  DECLARE VARIABLE WilayahID	INTEGER;
  DECLARE VARIABLE Negara	VARCHAR(35);
  DECLARE VARIABLE Propinsi	VARCHAR(30);
  DECLARE VARIABLE Wilayah	VARCHAR(30);
BEGIN
  FOR SELECT 
        A.DID,  
	A.NegaraID, A.PropinsiID, A.WilayahID,
        N.Negara, P.Propinsi, W.Wilayah, 
        A.Kawasan, A.Gedung, A.Jalan, 
        A.PostalCode
      FROM Address A
        LEFT JOIN Negara N ON (A.NegaraID = N.NegaraID)
        LEFT JOIN Propinsi P ON (A.PropinsiID = P.PropinsiID)
        LEFT JOIN Wilayah W ON (A.WilayahID = W.WilayahID)
      WHERE (LID = :LID) AND (LinkType= :LinkType)
  INTO
    :DID,
    :NegaraID, :PropinsiID, :WilayahID,
    :Negara, :Propinsi, :Wilayah, 
    :Kawasan, :Gedung, :Jalan, 
    :PostalCode
  DO
  BEGIN
    Address = '';
    EXECUTE PROCEDURE AddComma :Address, :Gedung RETURNING_VALUES :Address;
    EXECUTE PROCEDURE AddComma :Address, :Jalan RETURNING_VALUES :Address;
    EXECUTE PROCEDURE AddComma :Address, :Kawasan RETURNING_VALUES :Address;
    IF (Address = '') THEN Address = NULL;

    Region = '';
    IF ((NegaraID=99) OR (NegaraID IS NULL)) THEN 
    BEGIN
      IF (WilayahID>0) THEN 
        EXECUTE PROCEDURE AddComma :Region, :Wilayah RETURNING_VALUES :Region;
      IF (PropinsiID>0) THEN 
        EXECUTE PROCEDURE AddComma :Region, :Propinsi RETURNING_VALUES :Region;
    END
    ELSE 
      EXECUTE PROCEDURE AddComma :Region, :Negara RETURNING_VALUES :Region;
    EXECUTE PROCEDURE AddComma :Region, :PostalCode RETURNING_VALUES :Region;
    IF (Region = '') THEN Region = NULL;

    SUSPEND;
  END
END^

SET TERM ; ^

/* ======================= */
SET TERM ^ ;

CREATE PROCEDURE FullAddress (LinkType CHAR)
RETURNS (
  DID	INTEGER,
  LID	INTEGER,
  Address	VARCHAR(175),
  Region	VARCHAR(110)
) AS
BEGIN
  FOR SELECT A.DID, A.LID FROM Address A
      WHERE LinkType= :LinkType
  INTO :DID, :LID DO
  BEGIN
    SELECT Address, Region 
	FROM RefFullAddress(:LID, :LinkType)
        WHERE DID=:DID
    INTO :Address, :Region;

    SUSPEND;
  END
END^

SET TERM ; ^
/* ======================= */

SET TERM ^ ;

/* Use update and trigger instead this stored proc */
CREATE PROCEDURE OnceRefreshCommunityName 
AS
  DECLARE VARIABLE DID INTEGER;
  DECLARE VARIABLE Angkatan	VARCHAR(22);
  DECLARE VARIABLE Brief	VARCHAR(2);
  DECLARE VARIABLE Khusus	VARCHAR(15);
  DECLARE VARIABLE Community VARCHAR(70);
BEGIN
  FOR SELECT Cs.DID, C.Community, C.Brief, Cs.Angkatan, Cs.Khusus
      FROM ACommunities Cs INNER JOIN Community C ON (Cs.CID = C.CID)
  INTO :DID, :Community, :Brief, :Angkatan, :Khusus DO
  BEGIN 
    IF (Brief IS NOT NULL) THEN 
    BEGIN
      Community=Brief;
      Angkatan=SUBSTRING(Angkatan FROM 3 FOR 4);
    END

    IF (Khusus IS NOT NULL) THEN   
      Angkatan= Angkatan || ' (' || Khusus || ')';

    IF (Angkatan IS NOT NULL) THEN
        Community = Community || ' - ' || Angkatan;

    UPDATE ACommunities SET Community=:Community WHERE DID=:DID;
  END 
END^

SET TERM ; ^
/* ======================= */
SELECT C.LinkType, C.Total, CT.ContactType, count(*) AS GrandTotal FROM
( SELECT lid, linktype, CTID, count(*) as Total  FROM contacts
  group by lid, linktype, CTID
) C
  inner join ContactType CT on (C.CTID=CT.CTID)
group by Total, LinkType, ContactType
ORDER BY Total Desc
/* check SQL above */
SET TERM ^ ;

ALTER PROCEDURE OnceRefreshContactsDID
RETURNS ( DID	INTEGER ) AS
  DECLARE VARIABLE LID1	INTEGER;
  DECLARE VARIABLE CTID1	INTEGER;
  DECLARE VARIABLE LinkType1	CHAR;
  DECLARE VARIABLE LID2	INTEGER;
  DECLARE VARIABLE CTID2	INTEGER;
  DECLARE VARIABLE LinkType2	CHAR;  
BEGIN
  LID1=-1;
  CTID1=-1;
  LinkType1='';
    
  FOR SELECT DID, LID, CTID, LinkType FROM Contacts 
    ORDER BY LinkType, CTID, LID 
  INTO :DID, :LID2, :CTID2, :LinkType2 DO
  BEGIN
    IF ((LID1<>LID2) OR (CTID1<>CTID2) OR (LinkType1<>LinkType2)) THEN 
	BEGIN /* New Group*/
	  LID1=LID2;   
	  CTID1=CTID2;
	  LinkType1=LinkType2;
	  	  	  
      SUSPEND; 
    END     
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
  DECLARE VARIABLE Contact VARCHAR(50);
BEGIN
  FOR SELECT DISTINCT LID FROM Contacts
      WHERE LinkType= :LinkType
  INTO :LID DO
  BEGIN
    HP = ''; Phone =''; Fax = ''; email=''; website='';

    FOR SELECT Contact, CTID FROM Contacts 
      WHERE (LID= :LID) AND (LinkType= :LinkType)                    
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
  DECLARE VARIABLE Temp VARCHAR(100);
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
    BEGIN      
      IF (CTID=3) THEN Temp=HP;
      ELSE IF (CTID=4) THEN Temp=Phone;
      ELSE IF (CTID=6) THEN Temp=Fax; 
      ELSE IF (CTID=8) THEN Temp=email; 
      ELSE IF (CTID=9) THEN Temp=website; 
      ELSE BREAK;

      IF ((Temp <> '')) THEN Temp = Temp || ', ';
      Temp = Temp || Contact;

      IF (CTID=3) THEN HP=Temp;
      ELSE IF (CTID=4) THEN Phone=Temp;
      ELSE IF (CTID=6) THEN Fax=Temp; 
      ELSE IF (CTID=8) THEN email=Temp; 
      ELSE IF (CTID=9) THEN website=Temp; 
    END

    SUSPEND;
  END
END^
SET TERM ; ^