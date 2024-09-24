### MySQL string finder 

- Connects to a existing mysql server
- uses information schema to populate array of tables in a database
- checks types of columns for VARCHAR/TEXT/CHAR
- checks all these columns for existing data using

``` LIKE ```

- example:

``` Select  * from table_name where name LIKE '%something_to_search%' ; ```