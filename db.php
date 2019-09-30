<?php
    $mysqli = new mysqli('localhost', 'brinajeha_brina', '8D#1-6Y8vmhr', 'brinajeha_Capture') or die($mysqli->error);

    function debug_to_console( $data ) {
        $output = $data;
        if ( is_array( $output ) )
            $output = implode( ',', $output);
    
        echo "<script>console.log( 'Debug: " . $output . "' );</script>";
    }
?>