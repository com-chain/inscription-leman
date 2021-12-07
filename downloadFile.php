<?php
class DownloadFile {

    public static function download($mime_type, $client_name, $path) {
        header('Content-Description: File Transfer');
        header("Content-type: ".$mime_type);
        header('Content-Disposition: attachment; filename="'.$client_name.'"');
        header('Content-Length: ' . filesize($path));
        readfile($path);
    }
}
 

?>
