/* General: Public Selection */
GRANT SELECT ON Collector	TO PUBLIC;
GRANT SELECT ON Source		TO PUBLIC;
GRANT SELECT ON Updater		TO PUBLIC;

GRANT SELECT ON Negara		TO PUBLIC;
GRANT SELECT ON Propinsi	TO PUBLIC;
GRANT SELECT ON Wilayah		TO PUBLIC;

GRANT SELECT ON ContactType	TO PUBLIC;

GRANT SELECT ON Community	TO PUBLIC;
GRANT SELECT ON Faculty	TO PUBLIC;
GRANT SELECT ON Department	TO PUBLIC;
GRANT SELECT ON Program		TO PUBLIC;

GRANT SELECT ON Competency	TO PUBLIC;
GRANT SELECT ON Strata		TO PUBLIC;
GRANT SELECT ON Field		TO PUBLIC;

GRANT ALL ON JobPosition	TO PUBLIC;
GRANT ALL ON JobType		TO PUBLIC;

GRANT SELECT ON Religion	TO PUBLIC;

/* Web View: Iluni */

GRANT SELECT ON Alumni		TO Iluni;
GRANT SELECT ON Organization	TO Iluni;
GRANT SELECT ON AOMap		TO Iluni;

GRANT SELECT ON Address		TO Iluni;

GRANT SELECT ON Contacts	TO Iluni;
GRANT SELECT ON ViewContacts	TO Iluni;

GRANT SELECT ON ACertifications	TO Iluni;

GRANT SELECT ON ACommunities	TO Iluni;


GRANT SELECT ON ACompetencies	TO Iluni;
GRANT SELECT ON ADegrees	TO Iluni;
GRANT SELECT ON AExperiences	TO Iluni;
GRANT SELECT ON AMemberShip	TO Iluni;
GRANT SELECT ON Society		TO Iluni;

GRANT SELECT ON OFields		TO Iluni;

GRANT SELECT ON Iklan		TO Iluni;

/* Data Entry (GTK/Delphi): CitraJaya */

GRANT ALL ON NEXT_ID	TO CitraJaya;
GRANT ALL ON NEXT_DID	TO CitraJaya;

GRANT ALL ON Alumni		TO CitraJaya;
GRANT ALL ON Organization	TO CitraJaya;
GRANT ALL ON AOMap		TO CitraJaya;

GRANT ALL ON Address		TO CitraJaya;

GRANT ALL ON Contacts		TO CitraJaya;
GRANT ALL ON ViewContacts	TO CitraJaya;

GRANT ALL ON ACertifications	TO CitraJaya;
GRANT ALL ON ACommunities	TO CitraJaya;
GRANT ALL ON ACompetencies	TO CitraJaya;
GRANT ALL ON ADegrees		TO CitraJaya;
GRANT ALL ON AExperiences	TO CitraJaya;
GRANT ALL ON AMemberShip	TO CitraJaya;
GRANT ALL ON Society		TO CitraJaya;

GRANT ALL ON OFields		TO CitraJaya;

GRANT ALL ON Iklan		TO CitraJaya;

/* Data Entry (GTK/Delphi): CitraJaya */

GRANT ALL ON ExtendedAlumni	TO CitraJaya;
GRANT ALL ON ExtendedCommunity	TO CitraJaya;
GRANT ALL ON ExtendedOrganization	TO CitraJaya;
GRANT ALL ON FullCommunityName	TO CitraJaya;
GRANT ALL ON FullName	TO CitraJaya;
GRANT ALL ON Lahir	TO CitraJaya;

GRANT EXECUTE ON PROCEDURE RefContactList TO CitraJaya;
GRANT EXECUTE ON PROCEDURE AddComma TO CitraJaya;

/*----------------*/

