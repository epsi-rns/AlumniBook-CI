/* Alumni */

INSERT INTO Alumni (AID, Name, Prefix, Suffix, UpdaterID, CollectorID, SourceID, BirthPlace, BirthDate, Gender, ReligionID)
VALUES (25, 'Epsiarto Rizqi Nurwijayadi', NULL, 'ST', 11, 21, 11, 'Sungai gerong', '11/4/1975', 'M', 1);

INSERT INTO Alumni (AID, Name, Prefix, Suffix, UpdaterID, CollectorID, SourceID, BirthPlace, BirthDate, Gender, ReligionID)
VALUES (283, 'Aswil Nazir', 'Ir.', NULL, 13, 21, 11, 'Jakarta', '08/01/1955', 'M', 1);

INSERT INTO Alumni (AID, Name, Prefix, Suffix, UpdaterID, CollectorID, SourceID, BirthPlace, BirthDate, Gender, ReligionID)
VALUES (3, 'Desrinda Syahfarin', NULL, 'ST, MSc.', 13, 21, 999, NULL, NULL, 'F', 1);

INSERT INTO Alumni (AID, Name, Prefix, Suffix, UpdaterID, CollectorID, SourceID, BirthPlace, BirthDate, Gender, ReligionID)
VALUES (4, 'Idris Hadi Sikumbang', NULL, 'ST, MSc.', 13, 21, 999, NULL, NULL, 'M', 1);

INSERT INTO Alumni (AID, Name, Prefix, Suffix, UpdaterID, CollectorID, SourceID, BirthPlace, BirthDate, Gender, ReligionID)
VALUES (5, 'Jos Istiyanto', NULL, 'ST', 11, 21, 999, 'Pemalang', '01/27/1975', 'M', 1);



/* Organization */

INSERT INTO Organization (OID, Organization, UpdaterID, CollectorID, SourceID, ParentID, HasBranch, Product)
VALUES (1, 'Universitas Indonesia', 13, 21, 999, NULL, 'T', 'Pendidikan');

INSERT INTO Organization (OID, Organization, UpdaterID, CollectorID, SourceID, ParentID, HasBranch)
VALUES (3, 'Fakultas Teknik UI', 13, 21, 999, 1, 'T');

INSERT INTO Organization (OID, Organization, UpdaterID, CollectorID, SourceID, ParentID, HasBranch)
VALUES (10, 'Departemen Mesin FTUI', 13, 21, 999, 3, 'F');

INSERT INTO Organization (OID, Organization, UpdaterID, CollectorID, SourceID, ParentID, HasBranch)
VALUES (100, 'Freelance (Tanpa Organisasi)', 11, 21, 999, NULL, 'F');

INSERT INTO Organization (OID, Organization, UpdaterID, CollectorID, SourceID, ParentID, HasBranch)
VALUES (25, 'Citra Jayaara Andalan, PT.', 11, 21, 999, NULL, 'F');

INSERT INTO Organization (OID, Organization, UpdaterID, CollectorID, SourceID, ParentID, HasBranch, Product)
VALUES (35, 'Baja Beton.', 11, 21, 999, NULL, 'F', 'Wire Rod Business');

INSERT INTO Organization (OID, Organization, UpdaterID, CollectorID, SourceID, ParentID, HasBranch, Product)
VALUES (283, 'Dexa Medica PT.', 13, 21, 999, NULL, 'F', 'Obat-obatan');


/* Map */

INSERT INTO AOMap (MID, AID, OID, Department, JobTypeID, JobPositionID)
VALUES (1, 25, 35, NULL, 6, 6);

INSERT INTO AOMap (MID, AID, OID, Department, JobTypeID, JobPositionID)
VALUES (2, 283, 283, 'Corporate IT', 3, 6);

