UPDATE produtos
SET linha_numero = CAST(REGEXP_SUBSTR(modelo, '[0-9]+') AS UNSIGNED)
WHERE linha_numero = 0 AND modelo REGEXP 'iPhone[[:space:]]*[0-9]+';