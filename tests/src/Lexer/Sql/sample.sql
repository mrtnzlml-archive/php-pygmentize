SELECT b.isbn, b.title, b.price, sales.items_sold, sales.company_nm -- comment
FROM Book b
JOIN (
  SELECT SUM(Items_Sold) Items_Sold, Company_Nm, ISBN
  FROM Book_Sales
  GROUP BY Company_Nm, ISBN
) sales ON sales.isbn = b.isbn
/*
 multiline
 */
CREATE TABLE shop (
  article INT (4) UNSIGNED ZEROFILL DEFAULT '0000' NOT NULL,
  dealer CHAR(20) DEFAULT '' NOT NULL,
  price DOUBLE (16, 2) DEFAULT '0.00' NOT NULL, PRIMARY KEY (article, dealer)
);
INSERT INTO shop VALUES (1, 'A', 3.45), (1, 'B', 3.99), (2, 'A', 10.99), (3, 'B', 1.45), (3, 'C', 1.69), (3, 'D', 1.25), (4, 'D', 19.95);

SELECT AVG(CAST(browser->'resolution'->>'x' AS integer)) AS width,
	AVG(CAST(browser->'resolution'->>'y' AS integer)) AS height
FROM events;
