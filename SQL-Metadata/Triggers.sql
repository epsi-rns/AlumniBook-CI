CREATE EXCEPTION OrgHasMap
'Alumni mapped to this organization, exclude before delete.';

CREATE EXCEPTION OrgHasBranch
'Organization has branch, exclude before delete.';

CREATE EXCEPTION AlumniHasMap
'Organization mapped to this alumni, exclude before delete.';

/*----------------*/

SET TERM ^ ;

CREATE TRIGGER PreventOrgDetail FOR Organization
ACTIVE BEFORE DELETE POSITION 0
AS
  DECLARE VARIABLE ID INTEGER;
  DECLARE VARIABLE Total INTEGER;
BEGIN 
  ID = old.OID;

  SELECT COUNT(*) FROM AOMap WHERE OID=:ID INTO :Total;
  IF (Total>0) THEN EXCEPTION OrgHasMap;

  SELECT COUNT(*) FROM Organization WHERE ParentID=:ID INTO :Total;
  IF (Total>0) THEN EXCEPTION OrgHasBranch;
END^

SET TERM ; ^ 
/*----------------*/
SET TERM ^ ;

CREATE TRIGGER PreventAlumniDetail FOR Alumni
ACTIVE BEFORE DELETE POSITION 0
AS
  DECLARE VARIABLE ID INTEGER;
   DECLARE VARIABLE Total INTEGER;
BEGIN 
  ID = old.AID;

  SELECT COUNT(*) FROM AOMap WHERE AID=:ID INTO :Total;
  IF (Total>0) THEN EXCEPTION AlumniHasMap;
END^

SET TERM ; ^ 

/*----------------*/
SET TERM ^ ;

CREATE TRIGGER CleanOrgDetail FOR Organization
ACTIVE AFTER DELETE POSITION 0
AS
  DECLARE VARIABLE ID INTEGER; 
BEGIN 
  ID = old.OID;
  DELETE FROM Address WHERE (LID=:ID) AND (LinkType='O');
  DELETE FROM Contacts WHERE (LID=:ID) AND (LinkType='O');
END^

SET TERM ; ^ 
/*----------------*/
SET TERM ^ ;

CREATE TRIGGER CleanAlumniDetail FOR Alumni
ACTIVE AFTER DELETE POSITION 0
AS
  DECLARE VARIABLE ID INTEGER; 
BEGIN 
  ID = old.AID;
  DELETE FROM Address WHERE (LID=:ID) AND (LinkType='A');
  DELETE FROM Contacts WHERE (LID=:ID) AND (LinkType='A');
END^

SET TERM ; ^
/*----------------*/ 
SET TERM ^ ;

CREATE TRIGGER CleanMapDetail FOR AOMap
ACTIVE AFTER DELETE POSITION 0
AS
  DECLARE VARIABLE ID INTEGER; 
BEGIN 
  ID = old.MID;
  DELETE FROM Address WHERE (LID=:ID) AND (LinkType='M');
  DELETE FROM Contacts WHERE (LID=:ID) AND (LinkType='M');
END^

SET TERM ; ^ 
/*----------------*/
SET TERM ^ ;

CREATE TRIGGER SET_CommunityAlias FOR ACommunities
ACTIVE BEFORE INSERT OR UPDATE POSITION 0
AS
  DECLARE VARIABLE ID INTEGER;
  DECLARE VARIABLE ProgramID INTEGER;
  DECLARE VARIABLE DepartmentID INTEGER;    
  DECLARE VARIABLE Comm1	VARCHAR(70);
  DECLARE VARIABLE Year1	VARCHAR(22);
  DECLARE VARIABLE Brief	VARCHAR(2);
BEGIN
  ID = new.CID;

  SELECT Community, Brief, ProgramID, DepartmentID
  FROM Community WHERE CID=:ID
  INTO :Comm1, :Brief, :ProgramID, :DepartmentID;

  /* Shortcut to avoid heavy select query */  
  new.ProgramID = ProgramID;
  new.DepartmentID = DepartmentID;   

  IF (Brief IS NOT NULL) THEN 
  BEGIN
    Comm1 = Brief;
    Year1 = SUBSTRING(new.Angkatan FROM 3 FOR 4);
  END
  ELSE Year1 = new.Angkatan;
  

  IF (new.Khusus IS NOT NULL) THEN   
    Year1 = Year1 || ' (' || new.Khusus || ')';

  IF (new.Angkatan IS NOT NULL) THEN
    Comm1 = Comm1 || ' - ' || Year1;
 
  new.Community = Comm1; 

END^

SET TERM ; ^
/*----------------*/
SET TERM ^ ;

CREATE TRIGGER SET_FullAddress FOR Address
ACTIVE BEFORE INSERT OR UPDATE POSITION 0
AS
  DECLARE VARIABLE ID INTEGER;
  DECLARE VARIABLE TempStr	VARCHAR(50);  
  DECLARE VARIABLE Address	VARCHAR(175);
  DECLARE VARIABLE Region	VARCHAR(110);  
BEGIN
  Address = '';
  Region = '';  

  TempStr = new.Gedung;
  EXECUTE PROCEDURE AddComma :Address, :TempStr RETURNING_VALUES :Address;
  TempStr = new.Jalan;    
  EXECUTE PROCEDURE AddComma :Address, :TempStr RETURNING_VALUES :Address;
  TempStr = new.Kawasan;    
  EXECUTE PROCEDURE AddComma :Address, :TempStr RETURNING_VALUES :Address;

  IF (Address = '') THEN Address = NULL;
  new.Address = Address; 
  
  IF ((new.NegaraID=99) OR (new.NegaraID IS NULL)) THEN 
  BEGIN
    IF (new.WilayahID>0) THEN 
    BEGIN
      ID = new.WilayahID;
      SELECT Wilayah FROM Wilayah WHERE WilayahID=:ID INTO :TempStr;    
      EXECUTE PROCEDURE AddComma :Region, :TempStr RETURNING_VALUES :Region;
    END  
    IF (new.PropinsiID>0) THEN 
    BEGIN
      ID = new.PropinsiID;
      SELECT Propinsi FROM Propinsi WHERE PropinsiID=:ID INTO :TempStr;    
      EXECUTE PROCEDURE AddComma :Region, :TempStr RETURNING_VALUES :Region;
    END  
  END
  ELSE 
  BEGIN
    ID = new.NegaraID;
    SELECT Negara FROM Negara WHERE NegaraID=:ID INTO :TempStr;    
    EXECUTE PROCEDURE AddComma :Region, :TempStr RETURNING_VALUES :Region;
  END  

  TempStr = new.PostalCode;    
  EXECUTE PROCEDURE AddComma :Region, :TempStr RETURNING_VALUES :Region;

  IF (Region = '') THEN Region = NULL;
  new.Region = Region;     
END^

SET TERM ; ^
/*----------------*/ 
SET TERM ^ ;

CREATE TRIGGER SET_ViewContacts FOR Contacts
ACTIVE AFTER INSERT OR UPDATE POSITION 0
AS
  DECLARE VARIABLE DID INTEGER;
  DECLARE VARIABLE LID INTEGER;
  DECLARE VARIABLE CTID INTEGER;
  DECLARE VARIABLE LinkType CHAR;    
  DECLARE VARIABLE Contact	VARCHAR(50);
  DECLARE VARIABLE Contacts	VARCHAR(200);
BEGIN
  Contacts = '';
  LID = new.LID;
  CTID = new.CTID;
  LinkType = new.LinkType;  
                       
  /* 1 */					      
  FOR SELECT Contact FROM Contacts
  WHERE (LID = :LID) AND (CTID = :CTID) AND (LinkType = :LinkType)
  INTO :Contact DO 
  EXECUTE PROCEDURE AddComma :Contacts, :Contact RETURNING_VALUES :Contacts;

  /* 2 */
  SELECT DID FROM ViewContacts 
  WHERE (LID = :LID) AND (LinkType = :LinkType)
  INTO :DID;

  /* 3 */  
  IF (DID IS NULL) THEN 
  BEGIN
    DID = Gen_ID(Detail_ID, 1);
    INSERT INTO ViewContacts (DID, LID, LinkType) 
	  VALUES (:DID, :LID, :LinkType);
  END
  
  /* 4 */
  IF (new.CTID=3) THEN UPDATE ViewContacts SET HP=:Contacts WHERE DID=:DID;
  ELSE IF (new.CTID=4) THEN UPDATE ViewContacts SET Phone=:Contacts WHERE DID=:DID;
  ELSE IF (new.CTID=6) THEN UPDATE ViewContacts SET Fax=:Contacts WHERE DID=:DID;
  ELSE IF (new.CTID=8) THEN UPDATE ViewContacts SET email=:Contacts WHERE DID=:DID;
  ELSE IF (new.CTID=9) THEN UPDATE ViewContacts SET website=:Contacts WHERE DID=:DID;			    
      
END^

SET TERM ; ^ 
/*----------------*/ 
SET TERM ^ ;

CREATE TRIGGER UNSET_ViewContacts FOR Contacts
ACTIVE AFTER DELETE POSITION 0
AS
  DECLARE VARIABLE DID	INTEGER;
  DECLARE VARIABLE LID	INTEGER;
  DECLARE VARIABLE CTID	INTEGER;
  DECLARE VARIABLE LinkType CHAR;    
  DECLARE VARIABLE Total	INTEGER;
  DECLARE VARIABLE Contact	VARCHAR(50);
  DECLARE VARIABLE Contacts	VARCHAR(200);  
BEGIN
  LID = old.LID;
  CTID = old.CTID;
  LinkType = old.LinkType;  
                       
  /* 1 */
  SELECT DID FROM ViewContacts 
  WHERE (LID = :LID) AND (LinkType = :LinkType)
  INTO :DID;

  IF (DID IS NOT NULL) THEN
  BEGIN
    /* 2 */
    SELECT COUNT(*) FROM Contacts
    WHERE (LID = :LID) AND (LinkType = :LinkType)
    INTO :Total;
  
    IF (Total=0) THEN
    BEGIN
      /* 3 */
      DELETE FROM ViewContacts WHERE DID=:DID;
    END
    ELSE
    BEGIN	
      /* 4 */				  	      
      SELECT COUNT(*) FROM Contacts
      WHERE (LID = :LID) AND (CTID = :CTID) AND (LinkType = :LinkType)
      INTO :Total; 
  
      /* 5 */
      IF (Total=0) THEN
      BEGIN
        IF (CTID=3) THEN UPDATE ViewContacts SET HP=NULL WHERE DID=:DID;
        ELSE IF (CTID=4) THEN UPDATE ViewContacts SET Phone=NULL WHERE DID=:DID;
        ELSE IF (CTID=6) THEN UPDATE ViewContacts SET Fax=NULL WHERE DID=:DID;
        ELSE IF (CTID=8) THEN UPDATE ViewContacts SET email=NULL WHERE DID=:DID;
        ELSE IF (CTID=9) THEN UPDATE ViewContacts SET website=NULL WHERE DID=:DID;
      END
      ELSE
      BEGIN
        Contacts = '';      
		/* 6 */					      
		FOR SELECT Contact FROM Contacts
		WHERE (LID = :LID) AND (CTID = :CTID) AND (LinkType = :LinkType)
		INTO :Contact DO 
		EXECUTE PROCEDURE AddComma :Contacts, :Contact RETURNING_VALUES :Contacts;    
		
		/* 4 */
		IF (CTID=3) THEN UPDATE ViewContacts SET HP=:Contacts WHERE DID=:DID;
		ELSE IF (CTID=4) THEN UPDATE ViewContacts SET Phone=:Contacts WHERE DID=:DID;
		ELSE IF (CTID=6) THEN UPDATE ViewContacts SET Fax=:Contacts WHERE DID=:DID;
		ELSE IF (CTID=8) THEN UPDATE ViewContacts SET email=:Contacts WHERE DID=:DID;
		ELSE IF (CTID=9) THEN UPDATE ViewContacts SET website=:Contacts WHERE DID=:DID;		    
      END /* Total */
    END /* Total */
  END /* DID */					    
      
END^

SET TERM ; ^ 
/*----------------*/
SET TERM ^ ;

/* Precaution: Heavy Query */
CREATE PROCEDURE OnceRefreshContacts AS
  DECLARE VARIABLE DID	INTEGER;
  DECLARE VARIABLE CTID	INTEGER;
  DECLARE VARIABLE LID	INTEGER;
  DECLARE VARIABLE LinkType	CHAR;  
  DECLARE VARIABLE Contact	VARCHAR(50);
  DECLARE VARIABLE HP		VARCHAR(100);	/* 3 */
  DECLARE VARIABLE Phone	VARCHAR(100);	/* 4 */
  DECLARE VARIABLE Fax		VARCHAR(100);	/* 6 */
  DECLARE VARIABLE email	VARCHAR(100);	/* 8 */
  DECLARE VARIABLE website	VARCHAR(100);	/* 9 */
BEGIN  
  /* (f)root loop */
  FOR SELECT DISTINCT LID, LinkType FROM Contacts
  INTO :LID, :LinkType DO
  BEGIN
    HP = ''; Phone =''; Fax = ''; email=''; website='';

	/* 1 :: heavy one */
    FOR SELECT Contact, CTID FROM Contacts 
      WHERE (LID= :LID) AND (LinkType= :LinkType)
    INTO :Contact, :CTID DO
    IF (Contact IS NOT NULL) THEN
      IF (CTID=3) THEN EXECUTE PROCEDURE AddComma :HP, :Contact RETURNING_VALUES :HP;
      ELSE IF (CTID=4) THEN EXECUTE PROCEDURE AddComma :Phone, :Contact RETURNING_VALUES :Phone;
      ELSE IF (CTID=6) THEN EXECUTE PROCEDURE AddComma :Fax, :Contact RETURNING_VALUES :Fax;
      ELSE IF (CTID=8) THEN EXECUTE PROCEDURE AddComma :email, :Contact RETURNING_VALUES :email;
      ELSE IF (CTID=9) THEN EXECUTE PROCEDURE AddComma :website, :Contact RETURNING_VALUES :website;

    /* 2 */
    DID = NULL;
    SELECT DID FROM ViewContacts 
    WHERE (LID = :LID) AND (LinkType = :LinkType)
    INTO :DID;

    /* 3 */  
    IF (DID IS NULL) THEN 
    BEGIN
      DID = Gen_ID(Detail_ID, 1);
      INSERT INTO ViewContacts (DID, LID, LinkType) 
	    VALUES (:DID, :LID, :LinkType);
    END    

	/* 4 */
    UPDATE ViewContacts 
	  SET HP=NULLIF(:HP, ''), Phone=NULLIF(:Phone, ''), Fax=NULLIF(:Fax, ''),
	      email=NULLIF(:email, ''), website=NULLIF(:website, '') 
	WHERE DID=:DID;
  END

END^             

SET TERM ; ^
