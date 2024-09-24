### MySQL string finder 

- Connects to a existing mysql server
- uses information schema to populate array of tables in a database
- checks types of columns for VARCHAR/TEXT/CHAR
- checks all these columns for existing data using mysql operation: ``` LIKE ```
- example:
``` Select  * from table_name where name LIKE '%something_to_search%' ; ```

### purpose of this program


### how to use:

 - step 1
 ``` git clone https://github.com/AkmalCodes/mysql-string-finder.git ```
 - step 2
   - change db.php tp db.php.example
 - step 3
   - populate credentials for mysql database for connection in db.php
