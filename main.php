<?php

require_once("db.php");

$search_term = 'Licin Kosong'; // The term you want to search for

echo "Connected to MySQL successfully!\n";
echo "Searching for term: '$search_term'\n";

// Array to store all matched entries
$matched_entries = [];

// Step 1: Get all tables from the database
$tables_query = "SELECT TABLE_NAME FROM information_schema.tables WHERE table_schema = '$database'";
$tables_result = $mysqli->query($tables_query);

if ($tables_result && $tables_result->num_rows > 0) {
    // echo "Tables found in the database: \n";

    // Step 2: Loop through each table
    while ($table_row = $tables_result->fetch_assoc()) {
        $table_name = $table_row['TABLE_NAME']; // Corrected to TABLE_NAME (uppercase)

        // echo "Processing table: $table_name\n"; // Added statement to show which table is being processed

        // Step 3: Get all columns from the current table
        $columns_query = "SELECT COLUMN_NAME FROM information_schema.columns WHERE table_schema = '$database' AND table_name = '$table_name'";
        $columns_result = $mysqli->query($columns_query);

        if ($columns_result && $columns_result->num_rows > 0) {
            // Print columns of the current table
            // echo "Columns in table '$table_name':\n";

            // Build the query to search for 'honeycomb' in each column of the table
            $like_clauses = [];
            while ($column_row = $columns_result->fetch_assoc()) {
                $column_name = $column_row['COLUMN_NAME']; // Corrected to COLUMN_NAME (uppercase)
                $like_clauses[] = "`$column_name` LIKE '%$search_term%'";
            }

            // Combine the LIKE clauses for all columns
            $where_clause = implode(' OR ', $like_clauses);
            $search_query = "SELECT * FROM `$table_name` WHERE $where_clause";

            // echo "Executing search query for table '$table_name': $search_query\n"; // Added to display the search query

            // Step 4: Execute the search query
            $search_result = $mysqli->query($search_query);

            if ($search_result && $search_result->num_rows > 0) {
                // Step 5: Store the results for this table
                echo "Found matches in table '$table_name':\n";
                while ($row = $search_result->fetch_assoc()) {
                    $row['table_name'] = $table_name; // Add the table name to each row
                    $matched_entries[] = $row; // Store each matching row with table name in the main array
                }
            } else {
                // echo "No matches found in table '$table_name'.\n"; // Added statement if no matches are found
            }
        } else {
            // echo "No columns found in table '$table_name'.\n"; // Added statement if no columns are found
        }
    }

    // Step 6: Print all the matched entries at the end
    
    if (!empty($matched_entries)) {
        foreach ($matched_entries as $entry) {
            // echo "Table: " . $entry['table_name'] . "\n";
            unset($entry['table_name']); // Remove the table name before printing the row data
            // print_r($entry); // Display the matched row
        }
    } else {
        echo "No matches found in the entire database.\n";
    }

    // print_r($matched_entries);
} else {
    echo "No tables found in the database '$database'.\n";
}

// Close the MySQL connection
$mysqli->close();
