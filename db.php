<?php
    $mysqli = new mysqli('localhost', 'root', '', 'capture_project1') or die($mysqli->error);

    function debug_to_console( $data ) {
        $output = $data;
        if ( is_array( $output ) )
            $output = implode( ',', $output);
    
        echo "<script>console.log( 'Debug: " . $output . "' );</script>";
    }
?>