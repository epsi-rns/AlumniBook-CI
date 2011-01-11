INSERT INTO Address (DID, LID, LinkType, Kawasan, Gedung, Jalan, PostalCode, NegaraID, PropinsiID, WilayahID)
VALUES (1, 25, 'A', 'Pakualaman', NULL, 'Purwanggan 8', NULL, 99, 16, 248);

INSERT INTO Address (DID, LID, LinkType, Kawasan, Gedung, Jalan, PostalCode, NegaraID, PropinsiID, WilayahID)
VALUES (2, 35, 'O', 'Pasar Minggu', NULL, 'Jl. Rawa Bambu Raya 17F', '12620', 99, 13, 168);

INSERT INTO Address (DID, LID, LinkType, Kawasan, Gedung, Jalan, PostalCode, NegaraID, PropinsiID, WilayahID)
VALUES (3, 1, 'M', 'Cinere', NULL, NULL, '12620', 99, 12, 146);



INSERT INTO Contacts (DID, LID, LinkType, CTID, Contact)
VALUES (1, 25, 'A', 9, 'iluni.org');

INSERT INTO Contacts (DID, LID, LinkType, CTID, Contact)
VALUES (2, 35, 'O', 4, '021-6055-002');

INSERT INTO Contacts (DID, LID, LinkType, CTID, Contact)
VALUES (3, 1, 'M', 4, '021-6055-003');


INSERT INTO OFields (DID, OID, FieldID, Description) VALUES (1, 25, 3, NULL);
INSERT INTO OFields (DID, OID, FieldID, Description) VALUES (2, 35, 4, NULL);
INSERT INTO OFields (DID, OID, FieldID, Description) VALUES (3, 283, 2, NULL);


INSERT INTO ACommunities (DID, AID, CID, Angkatan, Khusus) VALUES (1, 25, 2, 1993, NULL);
INSERT INTO ACommunities (DID, AID, CID, Angkatan, Khusus) VALUES (2, 283, 3, 1974, NULL);
INSERT INTO ACommunities (DID, AID, CID, Angkatan, Khusus) VALUES (3, 3, 3, 1993, NULL);
INSERT INTO ACommunities (DID, AID, CID, Angkatan, Khusus) VALUES (4, 4, 8, 2002, NULL);
INSERT INTO ACommunities (DID, AID, CID, Angkatan, Khusus) VALUES (5, 5, 2, 1993, NULL);
INSERT INTO ACommunities (DID, AID, CID, Angkatan, Khusus) VALUES (6, 3, 47, 2008, NULL);


INSERT INTO ADegrees (DID, AID, StrataID, Admitted, Graduated, Degree, Institution, Major, Minor, Concentration)
VALUES (1, 25, 10, '1993', '1999', 'ST', 'University of Indonesia', 'Engineering', 'Mechanical', NULL);

INSERT INTO ADegrees (DID, AID, StrataID, Admitted, Graduated, Degree, Institution, Major, Minor, Concentration)
VALUES (2, 283, 10, '1974', '1980', 'Ir.', 'University of Indonesia', 'Engineering', 'Electrical', NULL);


INSERT INTO ACompetencies (DID, AID, CompetencyID, Description) VALUES (1, 25, 3, 'Sistim Informasi, Aplikasi Web');
INSERT INTO ACompetencies (DID, AID, CompetencyID, Description) VALUES (2, 25, 1, 'Bisnis Logam');
INSERT INTO ACompetencies (DID, AID, CompetencyID, Description) VALUES (3, 283, 2, NULL);
INSERT INTO ACompetencies (DID, AID, CompetencyID, Description) VALUES (4, 5, 7, NULL);


INSERT INTO ACertifications (DID, AID, Certification, Institution)
VALUES (1, 25, 'Test-Sertifikasi', 'Test-Institusi');


INSERT INTO AExperiences (DID, AID, Organization, JobPosition, YearIn, YearOut)
VALUES (1, 25, 'Citra Jayaara Andalan', 'Owner', NULL, 2000);

INSERT INTO AExperiences (DID, AID, Organization, JobPosition, Description, YearIn, YearOut)
VALUES (2, 25, 'Freelance', 'Coder (Programmer)', 'Aplikasi Web, Administrasi Linux', NULL, 2003);

INSERT INTO AExperiences (DID, AID, Organization, JobPosition, Description, YearIn, YearOut)
VALUES (3, 25, 'Baja Beton', 'Trainee', 'Business Startup Phase', NULL, 2010);

INSERT INTO AExperiences (DID, AID, Organization)
VALUES (4, 283, 'IBM');

INSERT INTO AExperiences (DID, AID, Organization)
VALUES (5, 283, 'Citibank N.A.');

INSERT INTO AExperiences (DID, AID, Organization)
VALUES (6, 283, 'Dexa Medica');

