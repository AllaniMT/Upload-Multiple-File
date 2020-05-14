<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST'):
//Setting Errors Array
    $errors             = array();
//Setting Array of images 
    $all_images         = array();
    $uploaded_files     = $_FILES['my_work'];
    $image_name         = $uploaded_files['name'];
    $image_type         = $uploaded_files['type'];
    $image_tmp_name     = $uploaded_files['tmp_name'];
    $image_size         = $uploaded_files['size'];
    $image_error        = $uploaded_files['error'];
//Set Allowed files Extansions
    $allowed_extensions = array(
        'jpg',
        'gif',
        'jpeg',
        'png'
    );
//error 4 is when no image uploaded
    if ($image_error[0] == 4):
        echo '<div>No File uploaded</div> ';
    else:
        //get how many image uploaded
        $files_count = count($image_name);
        //Looping throw all image 
        for ($i = 0; $i < $files_count; $i++) {
            $errors = array();
            
            //Get the image extansion
            $tmp                 = explode('.', $image_name[$i]);
            $image_extension[$i] = strtolower(end($tmp));
            
            
            //make  Random Name for file
            $image_random[$i] = rand(0, 100000000) . "." . $image_extension[$i];
            
            //check the file size if it is bigger than 4000000
            if ($image_size[$i] > 4000000):
                $errors[] = '<div>File Can\'t Be More Than 4000000</div>';
            endif;
            
            //Check If File extansion Is Valid
            if (!in_array($image_extension[$i], $allowed_extensions)):
                $errors[] = '<div>File is not Valid</div>';
            endif;
            
            
            
            // Check If has no errors
            if (empty($errors)):
            //Move The File
                move_uploaded_file($image_tmp_name[$i], $_SERVER['DOCUMENT_ROOT'] . '\PHP_OOP\OOP\uploadFilePhp\\' . $image_random[$i]);
                
                echo '<div style ="background-color: #EEE; padding:10px; margin-bottom: 20px">';
                echo '<div>File number ' . ($i + 1) . 'Uploaded' . '<br>' . '</div>';
                echo '<div>File name: ' . $image_name[$i] . '</div>';
                echo '<div>File new name : ' . $image_random[$i] . '</div>';
                
                $all_images[] = $image_random[$i];
                echo '</div>';
            else:
                //Loop Through Errors
                echo '<div style ="background-color: #EEE; padding:10px; margin-bottom: 20px">';
                echo 'Error for File number' . ($i + 1) . '<br>';
                echo 'File name: ' . $image_name[$i] . '<br>';
                foreach ($errors as $error):
                    echo $error;
                endforeach;
                echo '</div>';
            endif;
        }
    endif;
// to save it all in the database
    $img_field = implode(',', $all_images);
endif;

?>
<form class="" action="" method="post" enctype="multipart/form-data">
    <input type="file" name="my_work[]" multiple="multiple"   value=""><br><br>
    <input type="submit" name="" value="Upload">
</form>