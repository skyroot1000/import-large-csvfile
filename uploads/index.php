<?php
    include "../config.php";
?>

<html>
    <head>
        <title></title>

        <?php
            $ROW_MAX = 1000;

            if(isset($_POST['but_import'])){
                
                $targetFile = "../Book.csv";
                        
                //check file exists
                if(!file_exists($targetFile)){
                    return;
                }                

                //Reading the file
                $file = fopen($targetFile, "r");
                
                $index = 0;
                $csvRows = array();

                $fieldsName = fgetcsv($file, 1000, ",");
                $fieldCount = count($fieldsName);

                $querySelect = "Select count(*) as allcount from csvdata where ID = ";
                $queryInsert = ' INSERT INTO "csvdata" VALUES';
                $queryBody = "(";

                $rowCount = 0;
                

                while (($row = fgetcsv($file, 1000, ",")) != FALSE){

                    $query = $querySelect . $row[0];    //Add id to query
                    
                    $retrieve_data = mysqli_query($connection, $query);
                    $row = mysqli_fetch_assoc($retrieve_data);
                    // if ($row['allcount'] > 0)
                    //     continue;                    
                    
                    for( $i = 0; i < $fieldCount; $i++)
                        $queryBody = $queryBody . '"' . $row[$i] . '",';
                
                    $queryBody[-1] = '),';

                    if ($rowCount++ > $ROW_MAX) {
                        $queryBody[-1] = '';
                        $query = $queryInsert . ' '. $queryBody;
                        mysqli_query($con, $query_single);
                        $rowCount = 0;
                        $queryBody = '(';
                    }
                }

                if ($rowCount > 0) {    //not finished insert
                    $queryBody[-1] = '';
                    $query = $queryInsert . ' '. $queryBody;
                    mysqli_query($con, $query_single);
                }                
            }

            fclose($file);
            
            
        ?>
    </head>
    <body>
        <form method="post" action='' enctype="multipart/form-data">
            <input type="file" name=""><br>
            <input type="submit" name="but_import" value="Import">   
        </form>
    </body>
</html>
