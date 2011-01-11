CREATE VIEW ExtendedOrganization AS 
SELECT 
  O.OID, O.Organization, O.Product, O.Last_Update,
  O.SourceID, 
  F.Field, O.HasBranch, O.ParentID,
  M.Description, M.Department, JP.JobPosition, A.Name  
FROM Organization O
  LEFT JOIN OFields Fs ON (Fs.OID =  O.OID)
    LEFT JOIN Field F ON (Fs.FieldID = F.FieldID)  
  LEFT JOIN AOMAP M ON (M.OID=O.OID)
    LEFT JOIN Alumni A ON (M.AID=A.AID)
    LEFT JOIN JobPosition JP ON (M.JobPositionID=JP.JobPositionID)
;

CREATE VIEW FullCommunityName (AID, Community) AS
SELECT Cs.AID,
  CASE
    WHEN (Cs.Khusus IS NOT NULL) THEN C.Community || ' - ' || Cs.Khusus
    WHEN (Cs.Angkatan IS NOT NULL) THEN C.Community || ' - ' || Cs.Angkatan
  ELSE C.Community
  END AS Community
FROM ACommunities Cs 
  INNER JOIN Community C ON (Cs.CID = C.CID);


CREATE VIEW ExtendedCommunity
(AID, Community, Angkatan, Program, Department, ProgramID, DepartmentID) AS
SELECT Cs.AID, Cs.Community, Cs.Angkatan, 
  P.Program, D.Department, C.ProgramID, C.DepartmentID
FROM ACommunities Cs
  LEFT JOIN Community C ON (Cs.CID = C.CID)
  LEFT JOIN Program P ON (C.ProgramID = P.ProgramID)
  LEFT JOIN Department D ON (C.DepartmentID = D.DepartmentID);

CREATE VIEW FullName (AID, FullName) AS
SELECT AID, 
  CASE 
    WHEN (Prefix IS NOT NULL) AND (Suffix IS NOT NULL) 
      THEN Prefix || ' ' || Name || ', ' || Suffix
    WHEN (Prefix IS NOT NULL) 
      THEN Prefix || ' ' || Name
    WHEN (Suffix IS NOT NULL) 
      THEN Name || ', ' || Suffix
    ELSE Name
  END AS FullName
FROM Alumni;

CREATE VIEW ExtendedAlumni AS 
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
    LEFT JOIN JobType JT ON M.JobTypeID = JT.JobTypeID
    LEFT JOIN JobPosition JP ON (M.JobPositionID=JP.JobPositionID)
;     

CREATE VIEW Lahir (AID, Name, SourceID, BirthDate, Tanggal, Bulan, Tahun, Hari, Lahir)
AS 
SELECT AID, Name, SourceID, BirthDate,   
  EXTRACT(day FROM BirthDate) as Tanggal,
  EXTRACT(month FROM BirthDate) as Bulan, 
  EXTRACT(year FROM BirthDate) as Tahun,
  CASE EXTRACT(weekday FROM BirthDate) 
    WHEN 0 THEN 'Minggu'
    WHEN 1 THEN 'Senin'
    WHEN 2 THEN 'Selasa'
    WHEN 3 THEN 'Rabu'
    WHEN 4 THEN 'Kamis'
    WHEN 5 THEN 'Jumat'
    WHEN 6 THEN 'Sabtu'
  END AS Hari,
  CAST(Birthdate AS char(15)) as Lahir
FROM Alumni
WHERE BirthDate IS NOT NULL;