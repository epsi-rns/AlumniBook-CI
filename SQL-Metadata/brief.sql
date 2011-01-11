
-------------------------------------------
Contacts=60
Repost...
/* --Touch Trigger --*/ 
UPDATE ACommunities Set Community=NULL;	/* Refresh Community Name... */
UPDATE Address Set Address=NULL;		/* Refresh Address and Region... */
EXECUTE PROCEDURE OnceRefreshContacts;	/* Refresh Contacts... */


-Unsolved-where-clause-----------To-Do----------------------------
no problemas
-in-solving------------To-Do----------------------------
