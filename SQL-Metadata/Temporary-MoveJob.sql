/*----------------*/

ALTER TRIGGER ModifiedAlumni INACTIVE;
ALTER TRIGGER ModifiedOrganization INACTIVE;
ALTER TRIGGER ModifiedAOMap INACTIVE;

commit;

SET TERM ^ ;

/* reset last_update sekalian */

CREATE TRIGGER ModifiedAlumni2 FOR Alumni
ACTIVE BEFORE UPDATE POSITION 0
AS BEGIN 
  new.last_update=old.EntryDate;
END^

CREATE TRIGGER ModifiedOrganization2 FOR Organization
ACTIVE BEFORE UPDATE POSITION 0
AS BEGIN 
  new.last_update=old.EntryDate;
END^

SET TERM ; ^ 

commit;

update alumni set last_update=null;
update organization set last_update=null;

commit;

DROP TRIGGER ModifiedAlumni2;
DROP TRIGGER ModifiedOrganization2;

commit;

/*----------------*/
ALTER TABLE AOMap
	ADD JobTypeID	INTEGER;

commit;

ALTER TABLE Alumni DROP CONSTRAINT fkJobType;
DROP VIEW ExtendedAlumni;
commit;

ALTER TABLE AOMap
	ADD CONSTRAINT	fkJobType	FOREIGN KEY	(JobTypeID)	REFERENCES	JobType	(JobTypeID)	ON DELETE SET NULL ON UPDATE CASCADE;
commit;


/*----------------*/
SET TERM ^;

CREATE PROCEDURE Pindah 
AS
  DECLARE VARIABLE AID	INTEGER;
  DECLARE VARIABLE JTID	INTEGER;
BEGIN
  FOR SELECT AID, JobTypeID FROM Alumni
  INTO :AID, :JTID DO
  BEGIN
    UPDATE AOMap SET JobTypeID=JTID WHERE AID=:AID;
  END
END^

SET TERM ;^

commit;

EXECUTE PROCEDURE Pindah;
commit;

/*----------------*/

DROP PROCEDURE Pindah;

ALTER TABLE Alumni DROP JobTypeID;
ALTER TRIGGER ModifiedAlumni ACTIVE;
ALTER TRIGGER ModifiedOrganization ACTIVE;
ALTER TRIGGER ModifiedAOMap ACTIVE;

commit;

/*----------------*/
CREATE VIEW ExtendedAlumni AS 
...

GRANT ALL ON ExtendedAlumni	TO CitraJaya;

/*--Fix some bugs--------------*/
GRANT EXECUTE ON PROCEDURE RefContactList TO CitraJaya;
GRANT EXECUTE ON PROCEDURE AddComma TO CitraJaya;
