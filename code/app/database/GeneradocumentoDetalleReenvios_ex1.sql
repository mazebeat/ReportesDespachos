:ON ERROR EXIT
SET NOCOUNT ON;
EXEC $(spName) $(negocio), $(fechaini), $(fechafin);