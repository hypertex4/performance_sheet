<?php
if (isset($_POST['department'])){
    $error = '';
    $total_line = '';
    session_start();
    if ($_FILES['file']['name'] !=''){
        $allowed_ext = array('csv');
        $file_array = explode(".",$_FILES['file']['name']);
        $ext = end($file_array);
        if (in_array($ext, $allowed_ext)){
            $new_file_name = rand() . '.' . $ext;
            $_SESSION['csv_file_name'] = $new_file_name;
            move_uploaded_file($_FILES['file']['tmp_name'],'file/'.$new_file_name);
            $file_content = file('file/'.$new_file_name,FILE_SKIP_EMPTY_LINES);
            $total_line = count($file_content);
        } else {
            $error = 'Only csv file format is allowed';
        }
    } else {
        $error = 'Please select file';
    }

    if ($error != ''){
        $output = array('error' => $error);
    } else {
        $output = array('success' => true, 'total_line' => ($total_line - 1));
    }

    echo json_encode($output);
}

?>