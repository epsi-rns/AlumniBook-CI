SELECT A.AID, A.Name
FROM Alumni A WHERE A.AID NOT IN 
(SELECT LID FROM ADDRESS)

/* Interbase's Internal Table */
SELECT rf.RDB$RELATION_NAME AS RelationName
FROM RDB$RELATION_FIELDS rf;

SELECT RDB$RELATION_NAME
FROM RDB$RELATIONS
WHERE RDB$RELATION_NAME NOT STARTING WITH 'RDB$';

SELECT RDB$RELATION_NAME, RDB$FIELD_NAME
FROM RDB$RELATION_FIELDS
WHERE RDB$RELATION_NAME NOT STARTING WITH 'RDB$'

SELECT RDB$TYPE_NAME FROM RDB$TYPES
WHERE RDB$FIELD_NAME = 'RDB$FIELD_TYPE'

/* Interbase Sample */

SELECT OID, Organization FROM Organization
UNION ALL
SELECT AID, Name FROM Alumni

SELECT
  rf.RDB$RELATION_NAME AS RelationName,
  r.RDB$RELATION_ID AS ID,
  COUNT(*) AS Fields
FROM RDB$RELATION_FIELDS rf
INNER JOIN RDB$RELATIONS r ON r.RDB$RELATION_NAME = rf.RDB$RELATION_NAME
GROUP BY 2, 1


/* Firebird 1.5 */

SELECT
  c.DID, c.LID, 
  CASE
    WHEN (c.LinkType='O') THEN 'Organization'
    WHEN (c.LinkType='A') THEN 'Alumni'
    WHEN (c.LinkType='M') THEN 'Map'
    ELSE NULL
  END AS LinkType,
  c.CTID, c.Contact
FROM Contacts c;


-----------------------------------------------
On Wednesday, August 2, 2006, 9:55:34 AM, Ferry Setiawan wrote:

> Saya ingin mendapatkan daftar database/table/view/procedure/trigger di
> Interbase? mungkinkah? bagaimana querynya?

Table List:

select RDB$RELATION_NAME from RDB$RELATIONS
where (RDB$VIEW_BLR is NULL) and (RDB$SYSTEM_FLAG = 0)
ORDER BY RDB$RELATION_NAME

View List:

select RDB$RELATION_NAME from RDB$RELATIONS
where (RDB$VIEW_BLR is not NULL) and (RDB$SYSTEM_FLAG = 0)
ORDER BY RDB$RELATION_NAME

Trigger List:

select RDB$TRIGGER_NAME from RDB$TRIGGERS where (RDB$SYSTEM_FLAG = 0)

Procedure List:

select RDB$PROCEDURE_NAME from rdb$PROCEDURES WHERE (RDB$SYSTEM_FLAG = 0)

-- 
Salam,

-Jaimy Azle