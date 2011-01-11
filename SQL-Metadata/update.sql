CREATE TABLE Faculty (
	FacultyID	ID_NO		PRIMARY KEY,
	Faculty	VARCHAR(35)		NOT NULL UNIQUE	//	UNQ_Faculty
);			

ALTER TRIGGER MODIFIEDACOMMUNITIES INACTIVE;

ALTER TABLE ACommunities
	ADD FacultyID	INTEGER;
	
UPDATE ACommunities SET FacultyID=4;
	
ALTER TRIGGER MODIFIEDACOMMUNITIES ACTIVE;	

GRANT SELECT ON Department	TO PUBLIC;

ALTER TABLE Department
	ADD FacultyID	ID_NO;
	
ALTER TABLE Department
	ADD CONSTRAINT	fkFaculty
		FOREIGN KEY	(FacultyID)	REFERENCES	Faculty	(FacultyID)	
		ON DELETE SET NULL ON UPDATE CASCADE
;
	
DROP VIEW EXTENDEDALUMNI;
DROP VIEW EXTENDEDCOMMUNITY;

ALTER TABLE COMMUNITY DROP CONSTRAINT FKDEPT;

ALTER TABLE DEPARTMENT DROP CONSTRAINT INTEG_52;
	
ALTER TABLE DEPARTMENT 
	ALTER DEPARTMENT TYPE Varchar(40);
	
alter table DEPARTMENT
add constraint UNQ_Department
unique (DEPARTMENT)	

ALTER TABLE Community
	ADD CONSTRAINT	fkDept	FOREIGN KEY	(DepartmentID)	REFERENCES	Department	(DepartmentID)	
	ON DELETE SET NULL ON UPDATE CASCADE;

CREATE VIEW EXTENDEDCOMMUNITY (AID, COMMUNITY, ANGKATAN, PROGRAM, DEPARTMENT, PROGRAMID, DEPARTMENTID)AS  
SELECT Cs.AID, Cs.Community, Cs.Angkatan,  
  P.Program, D.Department, C.ProgramID, C.DepartmentID 
FROM ACommunities Cs 
  LEFT JOIN Community C ON (Cs.CID = C.CID) 
  LEFT JOIN Program P ON (C.ProgramID = P.ProgramID) 
  LEFT JOIN Department D ON (C.DepartmentID = D.DepartmentID);
GRANT DELETE, INSERT, REFERENCES, SELECT, UPDATE
 ON EXTENDEDCOMMUNITY TO  CITRAJAYA;
GRANT DELETE, INSERT, REFERENCES, SELECT, UPDATE
 ON EXTENDEDCOMMUNITY TO  SYSDBA WITH GRANT OPTION;

CREATE VIEW EXTENDEDALUMNI (AID, NAME, FULLNAME, LAST_UPDATE, SOURCEID, RELIGION, ANGKATAN, COMMUNITY, PROGRAM, DEPARTMENT, PROGRAMID, DEPARTMENTID, CERTIFICATION, INSTITUTION, COMPETENCY, DESCRIPTION, JOBTYPE, JOBPOSITION, ORGANIZATION)AS   
SELECT  
  A.AID, A.Name, Fn.FullName, A.Last_Update, 
  A.SourceID,  
  R.Religion,   
  C.Angkatan, C.Community, C.Program, C.Department, C.ProgramID, C.DepartmentID, 
  ACe.Certification, ACe.Institution, 
  Co.Competency,  
  M.Description, JT.JobType, JP.JobPosition, O.Organization 
FROM Alumni A 
  LEFT JOIN Religion R ON A.ReligionID = R.ReligionID 
  INNER JOIN FullName Fn ON (A.AID=Fn.AID) 
  LEFT JOIN ExtendedCommunity C ON (C.AID = A.AID) 
  LEFT JOIN ACertifications ACe ON (ACe.AID = A.AID) 
  LEFT JOIN ACompetencies ACo ON (ACo.AID = A.AID) 
    LEFT JOIN Competency Co ON (Co.CompetencyID = ACo.CompetencyID) 
  LEFT JOIN AOMAP M ON (M.AID=A.AID) 
    LEFT JOIN Organization O ON (M.OID=O.OID) 
    LEFT JOIN JobPosition JP ON (M.JobPositionID=JP.JobPositionID) 
    LEFT JOIN JobType JT ON M.JobTypeID = JT.JobTypeID 
;
GRANT DELETE, INSERT, REFERENCES, SELECT, UPDATE
 ON EXTENDEDALUMNI TO  SYSDBA WITH GRANT OPTION;






INSERT INTO Faculty (FacultyID, Faculty) VALUES (1, 'Kedokteran');
INSERT INTO Faculty (FacultyID, Faculty) VALUES (2, 'Kedokteran Gigi');
INSERT INTO Faculty (FacultyID, Faculty) VALUES (3, 'MIPA');
INSERT INTO Faculty (FacultyID, Faculty) VALUES (4, 'Teknik');
INSERT INTO Faculty (FacultyID, Faculty) VALUES (5, 'Hukum');
INSERT INTO Faculty (FacultyID, Faculty) VALUES (6, 'Ekonomi');
INSERT INTO Faculty (FacultyID, Faculty) VALUES (7, 'Ilmu Pengetahuan Budaya');
INSERT INTO Faculty (FacultyID, Faculty) VALUES (8, 'Psikologi');
INSERT INTO Faculty (FacultyID, Faculty) VALUES (9, 'Ilmu Sosial dan Ilmu Politik');
INSERT INTO Faculty (FacultyID, Faculty) VALUES (10, 'Kesehatan Masyarakat');
INSERT INTO Faculty (FacultyID, Faculty) VALUES (11, 'Keperawatan');
INSERT INTO Faculty (FacultyID, Faculty) VALUES (12, 'Ilmu Komputer');

update DEPARTMENT set FACULTYID=4;

update department set departmentid=401 where departmentid=1;
update department set departmentid=402 where departmentid=2;
update department set departmentid=403 where departmentid=3;
update department set departmentid=404 where departmentid=4;
update department set departmentid=405 where departmentid=5;
update department set departmentid=406 where departmentid=6;
update department set departmentid=407 where departmentid=7;
update department set departmentid=408 where departmentid=8;

ALTER TABLE COMMUNITY DROP CONSTRAINT FKDEPT;

update community set departmentid=401 where departmentid=1;
update community set departmentid=402 where departmentid=2;
update community set departmentid=403 where departmentid=3;
update community set departmentid=404 where departmentid=4;
update community set departmentid=405 where departmentid=5;
update community set departmentid=406 where departmentid=6;
update community set departmentid=407 where departmentid=7;
update community set departmentid=408 where departmentid=8;

ALTER TRIGGER MODIFIEDACOMMUNITIES INACTIVE;

update acommunities set departmentid=401 where departmentid=1;
update acommunities set departmentid=402 where departmentid=2;
update acommunities set departmentid=403 where departmentid=3;
update acommunities set departmentid=404 where departmentid=4;
update acommunities set departmentid=405 where departmentid=5;
update acommunities set departmentid=406 where departmentid=6;
update acommunities set departmentid=407 where departmentid=7;
update acommunities set departmentid=408 where departmentid=8;

ALTER TRIGGER MODIFIEDACOMMUNITIES ACTIVE;

ALTER TABLE Community
	ADD CONSTRAINT	fkDept	FOREIGN KEY	(DepartmentID)	REFERENCES	Department	(DepartmentID)	
	ON DELETE SET NULL ON UPDATE CASCADE;
	
	
	
