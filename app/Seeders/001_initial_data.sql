INSERT INTO produtos (condicao, modelo, linha_numero, armazenamento, preco, detalhes, foto_url)
SELECT 'Novo Lacrado', 'iPhone 16', 16, '128GB', 4999.90, '100', 'goveia-imports.jpg'
WHERE NOT EXISTS (SELECT 1 FROM produtos WHERE modelo = 'iPhone 16');
