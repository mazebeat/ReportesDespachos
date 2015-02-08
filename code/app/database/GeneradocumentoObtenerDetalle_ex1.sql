:ON ERROR EXIT
SET NOCOUNT ON;
EXEC $(spName) $(negocio), $(ciclo), $(mes), $(ano);