<?php
include('config.php');

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["post_merit_list"])) {
    // Retrieve minimum marks from the form
    $min_matric_marks = $_POST['min_matric_marks'];
    $min_inter_marks = $_POST['min_inter_marks'];

    // SQL query to get all students meeting the criteria
    $sql = "SELECT * FROM application 
            WHERE matric_marks >= $min_matric_marks 
            AND inter_marks >= $min_inter_marks
            ORDER BY matric_marks DESC, inter_marks DESC";
    
    $result = mysqli_query($conn, $sql);

    // Check if there are any qualified students
    if (mysqli_num_rows($result) > 0) {
        // Loop through the result and insert each student into the merit list
        while ($row = mysqli_fetch_assoc($result)) {
            $student_name = $row["student_name"];
            $matric_marks = $row["matric_marks"];
            $inter_marks = $row["inter_marks"];

            // Insert into the merit list table
            $insert_sql = "INSERT INTO merit_list (student_name, matric_marks, inter_marks) 
                           VALUES ('$student_name', '$matric_marks', '$inter_marks')";
            if (!mysqli_query($conn, $insert_sql)) {
                echo "Error: " . mysqli_error($conn);
            }
        }

        echo "Merit list posted successfully!";
    } else {
        echo "No students met the merit criteria.";
    }

    // Redirect back to the merit list view page after insertion
    header("Location: view_merit.php");
    exit;

} else {
    // If the form hasn't been submitted, redirect to the  page
    header("Location: add_merit.php");
    exit;
}
?>
