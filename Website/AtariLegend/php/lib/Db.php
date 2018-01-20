<?php
/* Database utility functions */
namespace AL\Db;

/**
 * Get an error context message
 *
 * @param $context Human friendly context message
 * @return An error context string
 */
function get_error_context($context) {
    return "(Context: $context)";
}

/**
 * Prepare a statement for the given query and parameters and handle errors
 *
 * @param $context A human-friendly string giving the context the query is running
 *  in. This will be output in error messages if something goes wrong
 * @param $mysqli Database connection
 * @param $query The SQL query to execute, using ? placeholders for parameters
 * @param $bind_string The string representing the types of parameters to bind
 *  (See mysqli_bind_param()), e.g. "ss" for 2 strings. Pass NULL if the query
 *  doesn't have parameters
 * @param $params The list of parameters to bind. Pass NULL if the query doesn't
 *  have parameters
 * @return A prepared statement that has been executed
 */
function execute_query($context, $mysqli, $query, $bind_string, ...$params) {
    $err_ctx = get_error_context($context);

    $stmt = $mysqli->prepare($query)
        or die("Error preparing query [$query] $err_ctx: ".$mysqli->error);

    if ($bind_string !== NULL) {
        $stmt->bind_param($bind_string, ...$params)
            or die("Error binding parameters $err_ctx");
    } else if (strstr($query, "?")) {
        die("Error: The query [$query] contained parameters (?) but didn't have a bind string $err_ctx");
    }

    $stmt->execute();

    return $stmt;
}

/**
 * Bind variables to a prepared statement and handle errors
 *
 * @param $context A human-friendly string giving the context the query is running
 *  in. This will be output in error messages if something goes wrong
 * @param $stmt Prepared statement to bind results on
 * @param $params Variables to bind to the statement result
 */
function bind_result($context, $stmt, &...$params) {
    $err_ctx = get_error_context($context);

    $stmt->bind_result(...$params)
        or die("Error binding results $err_ctx");
}
