DELETE FROM AOMap;
DELETE FROM Alumni;
DELETE FROM Organization WHERE ParentID IS NOT NULL;
DELETE FROM Organization;
DELETE FROM Contacts;	/* Delete all kind of contact */
DELETE FROM Address;	/* Delete all kind of address */