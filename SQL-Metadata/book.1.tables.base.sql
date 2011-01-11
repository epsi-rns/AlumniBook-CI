/* CREATE DATABASE 'D:\Documents and Settings\epsi\Desktop\IluniDB.gdb' */
SET SQL DIALECT 3;

CREATE DOMAIN ID_No AS					
		INTEGER		NOT NULL;


CREATE TABLE Alumni (
	AID	ID_NO		PRIMARY KEY,
	name	VARCHAR(50)		NOT NULL,
	prefix	VARCHAR(15),
	suffix	VARCHAR(10),
	showtitle	CHAR	DEFAULT 'F',
	entrydate	TIMESTAMP	DEFAULT 'now'	NOT NULL,
	last_update	TIMESTAMP	DEFAULT 'now'	NOT NULL,
	SourceID	ID_NO,
	UpdaterID	ID_NO,
	CollectorID	ID_NO,
	birthplace	VARCHAR(15),
	birthdate	DATE,
	gender	CHAR,
	ReligionID	INTEGER,
	Memo	BLOB SUB_TYPE TEXT SEGMENT SIZE 150
);					

CREATE TABLE Organization (
	OID	ID_NO		PRIMARY KEY,
	Organization	VARCHAR(50)		NOT NULL UNIQUE,
	entrydate	TIMESTAMP	DEFAULT 'now'	NOT NULL,
	last_update	TIMESTAMP	DEFAULT 'now'	NOT NULL,
	SourceID	ID_NO,
	UpdaterID	ID_NO,
	CollectorID	ID_NO,
	HasBranch	CHAR	DEFAULT 'F',
	ParentID	INTEGER,
	Product	VARCHAR(60),
	Memo	BLOB SUB_TYPE TEXT SEGMENT SIZE 150
);					

CREATE TABLE AOMap (
	MID	ID_NO	PRIMARY KEY,
	AID	ID_NO,
	OID	ID_NO,
	last_update	TIMESTAMP	DEFAULT 'now'	NOT NULL,
	Department	VARCHAR(60),
	JobTypeID	INTEGER,
	JobPositionID	INTEGER,
	Description	VARCHAR(40),
	Struktural	VARCHAR(50),
	Fungsional	VARCHAR(50)			
);					

CREATE TABLE Iklan (
	DID	ID_NO	PRIMARY KEY,
	OID	ID_NO
);					

CREATE TABLE Contacts (
	DID	ID_NO	PRIMARY KEY,
	LID	ID_NO,
	LinkType	CHAR	NOT NULL,
	CTID	ID_NO,
	Contact	VARCHAR(50)	NOT NULL
);					

CREATE TABLE Address (
	DID	ID_NO	PRIMARY KEY,
	LID	ID_NO,
	LinkType	CHAR	NOT NULL,
	Kawasan	VARCHAR(50),
	Gedung	VARCHAR(50),
	Jalan	VARCHAR(50),
	PostalCode	VARCHAR(7),
	NegaraID	INTEGER	DEFAULT 99,
	PropinsiID	INTEGER,
	WilayahID	INTEGER			
/* Maintained by trigger */
	Address	VARCHAR(175),
	Region	VARCHAR(110)
);	

CREATE TABLE OFields (
	DID	ID_NO	PRIMARY KEY,
	OID	ID_NO,
	FieldID	ID_NO,
	Description	VARCHAR(35)			
);					

CREATE TABLE ACommunities (
	DID	ID_NO	PRIMARY KEY,
	AID	ID_NO,
	CID	ID_NO,
	Angkatan	INTEGER,
	Khusus		VARCHAR(15),
/* Maintained by trigger, main alumna order by */
	Community	VARCHAR(70),
	ProgamID		ID_NO,
	DepartmentID	ID_NO		
);					

CREATE TABLE ADegrees (
	DID	ID_NO	PRIMARY KEY,
	AID	ID_NO,
	StrataID	ID_NO,
	Admitted	INTEGER,
	Graduated	INTEGER,
	Degree	VARCHAR(20)	DEFAULT 10,
	Institution	VARCHAR(40)	DEFAULT 'University of Indonesia',
	Major	VARCHAR(40)	DEFAULT 'Engineering',
	Minor	VARCHAR(40),
	Concentration	VARCHAR(40)			
);					

CREATE TABLE ACompetencies (
	DID	ID_NO	PRIMARY KEY,
	AID	ID_NO,
	CompetencyID	ID_NO,
	Description	VARCHAR(35)			
);					

CREATE TABLE Acertifications (
	DID	ID_NO	PRIMARY KEY,
	AID	ID_NO,
	Certification	VARCHAR(50)		NOT NULL,
	Institution	VARCHAR(20)			
);					

CREATE TABLE AExperiences (
	DID	ID_NO	PRIMARY KEY,
	AID	ID_NO,
	Organization	VARCHAR(35)		NOT NULL,
	Description	VARCHAR(50),
	JobPosition	VARCHAR(35),
	YearIn	INTEGER,
	YearOut	INTEGER			
);	

CREATE TABLE Source (
	SourceID	ID_NO		PRIMARY KEY,
	Source	VARCHAR(25)		NOT NULL UNIQUE	
);					

CREATE TABLE Updater (
	UpdaterID	ID_NO		PRIMARY KEY,
	Updater	VARCHAR(15)		NOT NULL UNIQUE	
);					

CREATE TABLE Collector (
	CollectorID	ID_NO		PRIMARY KEY,
	Collector	VARCHAR(15)		NOT NULL UNIQUE	
);					

CREATE TABLE ContactType (
	CTID	ID_NO		PRIMARY KEY,
	ContactType	VARCHAR(25)		NOT NULL UNIQUE
);					

CREATE TABLE Field (
	FieldID	ID_NO		PRIMARY KEY,
	Field	VARCHAR(35)		NOT NULL UNIQUE,
	Description	BLOB SUB_TYPE TEXT SEGMENT SIZE 150
);					

CREATE TABLE JobType (
	JobTypeID	ID_NO		PRIMARY KEY,
	JobType	VARCHAR(40)		NOT NULL UNIQUE	
);					

CREATE TABLE JobPosition (
	JobPositionID	ID_NO		PRIMARY KEY,
	JobPosition	VARCHAR(40)		NOT NULL UNIQUE	
);					

CREATE TABLE Religion (
	ReligionID	ID_NO		PRIMARY KEY,
	Religion	VARCHAR(20)		NOT NULL UNIQUE	
);					

CREATE TABLE Competency (					
	CompetencyID	ID_NO		PRIMARY KEY,
	Competency	VARCHAR(30)		NOT NULL UNIQUE,
	Description	BLOB SUB_TYPE TEXT SEGMENT SIZE 120
);					

CREATE TABLE Community (
	CID	ID_NO		PRIMARY KEY,
	Community	VARCHAR(50)		NOT NULL UNIQUE,
	Brief		VARCHAR(2)		UNIQUE,
	DepartmentID	INTEGER,
	FacultyID	INTEGER,	
	ProgramID	INTEGER,
);					

CREATE TABLE Faculty (
	FacultyID	ID_NO		PRIMARY KEY,
	Faculty	VARCHAR(35)		NOT NULL UNIQUE	/*	UNQ_Faculty */
);	

CREATE TABLE Department (
	DepartmentID	ID_NO		PRIMARY KEY,
	Department	VARCHAR(40)		NOT NULL UNIQUE,	/* UNQ_Department	*/
	FacultyID	ID_NO
);					

CREATE TABLE Program (
	ProgramID	ID_NO		PRIMARY KEY,
	Program	VARCHAR(15)		NOT NULL UNIQUE	
);					

CREATE TABLE Strata (
	StrataID	ID_NO		PRIMARY KEY,
	Strata	VARCHAR(15)		NOT NULL UNIQUE	
);					

CREATE TABLE Propinsi (
	PropinsiID	ID_NO		PRIMARY KEY,
	Propinsi	VARCHAR(30)		NOT NULL UNIQUE	
);					

CREATE TABLE Wilayah (
	WilayahID	ID_NO		PRIMARY KEY,
	PropinsiID	INTEGER,
	Wilayah	VARCHAR(30)		NOT NULL UNIQUE	
);					

CREATE TABLE Negara (
	NegaraID	ID_NO		PRIMARY KEY,
	Negara	VARCHAR(35)		NOT NULL UNIQUE	
);			

CREATE TABLE ViewContacts (
	DID	ID_NO	PRIMARY KEY,
	LID	ID_NO,
	LinkType	CHAR	NOT NULL,
/* Maintained by trigger */	
    HP		VARCHAR(100),	/* 3 */
    Phone	VARCHAR(100),	/* 4 */
    Fax		VARCHAR(100),	/* 6 */
    email	VARCHAR(100),	/* 8 */
    website	VARCHAR(100)	/* 9 */	
);	

ALTER TABLE Alumni
	ADD CONSTRAINT	fkSourceAlumni	
		FOREIGN KEY	(SourceID)	REFERENCES	Source	(SourceID),
	ADD CONSTRAINT	fkUpdaterAlumni	
		FOREIGN KEY	(UpdaterID)	REFERENCES	Updater	(UpdaterID),
	ADD CONSTRAINT	fkCollectorAlumni	
		FOREIGN KEY	(CollectorID)	REFERENCES	Collector	(CollectorID),
	ADD CONSTRAINT	ckGender	
		CHECK		(Gender IN ('M', 'F') OR Gender IS NULL),
	ADD CONSTRAINT	fkReligion	
		FOREIGN KEY	(ReligionID)	REFERENCES	Religion	(ReligionID)		
;									

ALTER TABLE Organization
	ADD CONSTRAINT	fkSourceOrg		
		FOREIGN KEY	(SourceID)	REFERENCES	Source	(SourceID),
	ADD CONSTRAINT	fkUpdaterOrg	
		FOREIGN KEY	(UpdaterID)	REFERENCES	Updater	(UpdaterID),
	ADD CONSTRAINT	fkCollectorOrg	
		FOREIGN KEY	(CollectorID)	REFERENCES	Collector	(CollectorID),
	ADD CONSTRAINT	ckHasBranch	
		CHECK		(HasBranch IN ('T', 'F')),
	ADD CONSTRAINT	fkParentOrg	
		FOREIGN KEY	(ParentID)	REFERENCES	Organization	(OID)									
;									

ALTER TABLE AOMap
	ADD CONSTRAINT	fkAlumniMap	
		FOREIGN KEY	(AID)	REFERENCES	Alumni	(AID)	
		ON DELETE CASCADE ON UPDATE CASCADE,
	ADD CONSTRAINT	fkOrganizationMap	
		FOREIGN KEY	(OID)	REFERENCES	Organization	(OID)	
		ON DELETE CASCADE ON UPDATE CASCADE,
	ADD CONSTRAINT	fkJobType	
		FOREIGN KEY	(JobTypeID)	REFERENCES	JobType	(JobTypeID)	
		ON DELETE SET NULL ON UPDATE CASCADE,
	ADD CONSTRAINT	fkJobPosition	
		FOREIGN KEY	(JobPositionID)	REFERENCES	JobPosition	(JobPositionID)	
		ON DELETE SET NULL ON UPDATE CASCADE
;									

ALTER TABLE Iklan
	ADD CONSTRAINT	fkOrganizationAdv	
		FOREIGN KEY	(OID)	REFERENCES	Organization	(OID)	
		ON DELETE CASCADE ON UPDATE CASCADE	
;									

ALTER TABLE Contacts
	ADD CONSTRAINT	ckLinkTypeContacts	
		CHECK		(LinkType IN ('O', 'A', 'M')),
	ADD CONSTRAINT	fkContactTypeContacts	
		FOREIGN KEY	(CTID)	REFERENCES	
		ContactType	(CTID)	ON DELETE CASCADE ON UPDATE CASCADE
;

ALTER TABLE Address
	ADD CONSTRAINT	ckLinkTypeAddress	
		CHECK		(LinkType IN ('O', 'A', 'M')),
	ADD CONSTRAINT	fkNegara	
		FOREIGN KEY	(NegaraID)	REFERENCES	Negara	(NegaraID)	
		ON DELETE SET NULL ON UPDATE CASCADE,
	ADD CONSTRAINT	fkPropinsi
		FOREIGN KEY	(PropinsiID)	REFERENCES	Propinsi	(PropinsiID)	
		ON DELETE SET NULL ON UPDATE CASCADE,
	ADD CONSTRAINT	fkWilayah	
		FOREIGN KEY	(WilayahID)	REFERENCES	Wilayah	(WilayahID)	
		ON DELETE SET NULL ON UPDATE CASCADE
;

ALTER TABLE OFields
	ADD CONSTRAINT	fkOrganizationFields	
		FOREIGN KEY	(OID)	REFERENCES	Organization	(OID)	
		ON DELETE CASCADE ON UPDATE CASCADE,
	ADD CONSTRAINT	fkMapOrgFields	
		FOREIGN KEY	(FieldID)	REFERENCES	Field	(FieldID)	
		ON DELETE SET NULL ON UPDATE CASCADE;									

ALTER TABLE ACommunities
	ADD CONSTRAINT	fkAlumniCommunities	
		FOREIGN KEY	(AID)	REFERENCES	Alumni	(AID)	
		ON DELETE CASCADE ON UPDATE CASCADE,
	ADD CONSTRAINT	fkMapAlumniCommunities	
		FOREIGN KEY	(CID)	REFERENCES	Community	(CID),
	ADD CONSTRAINT	ckAngkatan	
		CHECK					(Angkatan IS NULL OR Angkatan between 1964 and 2016)	
;									

ALTER TABLE ADegrees
	ADD CONSTRAINT	fkAlumniDegrees	
		FOREIGN KEY	(AID)	REFERENCES	Alumni	(AID)	
		ON DELETE CASCADE ON UPDATE CASCADE,
	ADD CONSTRAINT	fkStrataAlumni	
		FOREIGN KEY	(StrataID)	REFERENCES	Strata	(StrataID),
	ADD CONSTRAINT	ckAdmitted	
		CHECK	(Admitted IS NULL OR Admitted between 1964 and 2015),
	ADD CONSTRAINT	ckGraduated	
		CHECK	(Graduated IS NULL OR Graduated between 1964 and 2015);									

ALTER TABLE ACompetencies
	ADD CONSTRAINT	fkAlumniCompetencies	
		FOREIGN KEY	(AID)	REFERENCES	Alumni	(AID)	
		ON DELETE CASCADE ON UPDATE CASCADE,
	ADD CONSTRAINT	fkMapAlumniCompetencies	
		FOREIGN KEY	(CompetencyID)	REFERENCES	Competency	(CompetencyID)	
		ON DELETE SET NULL ON UPDATE CASCADE
;									

ALTER TABLE Acertifications
	ADD CONSTRAINT	fkAlumniCertifications	
		FOREIGN KEY	(AID)	REFERENCES	Alumni	(AID)	
		ON DELETE CASCADE ON UPDATE CASCADE
;

ALTER TABLE AExperiences
	ADD CONSTRAINT	fkAlumniExperiences	
		FOREIGN KEY	(AID)	REFERENCES	Alumni	(AID)	
		ON DELETE CASCADE ON UPDATE CASCADE,
	ADD CONSTRAINT	ckYearIn	
		CHECK			(YearIn IS NULL OR YearIn between 1964 and 2016),
	ADD CONSTRAINT	ckYearOut	
		CHECK			(YearOut IS NULL OR YearOut between 1964 and 2016)
;								

ALTER TABLE Community
	ADD CONSTRAINT	fkDept
		FOREIGN KEY	(DepartmentID)	REFERENCES	Department	(DepartmentID)	
		ON DELETE SET NULL ON UPDATE CASCADE,
	ADD CONSTRAINT	fkProg	
		FOREIGN KEY	(ProgramID)	REFERENCES	Program	(ProgramID)	
		ON DELETE SET NULL ON UPDATE CASCADE
;

ALTER TABLE Department
	ADD CONSTRAINT	fkFaculty
		FOREIGN KEY	(FacultyID)	REFERENCES	Faculty	(FacultyID)	
		ON DELETE SET NULL ON UPDATE CASCADE
;

ALTER TABLE Wilayah
	ADD CONSTRAINT	fkProp	
		FOREIGN KEY	(PropinsiID)	REFERENCES	Propinsi	(PropinsiID)	
		ON DELETE SET NULL ON UPDATE CASCADE
;

ALTER TABLE ViewContacts
	ADD CONSTRAINT	ckLinkTypeViewContacts	
		CHECK		(LinkType IN ('O', 'A', 'M'))
;

CREATE INDEX AddressLinkID ON Address (LID);
CREATE INDEX ContactsLinkID ON Contacts (LID);
