<?php
    $host = 'localhost';
    $uname = 'root';
    $pass = '';
    $db = 'hbwebsite';

    $con = mysqli_connect($host, $uname, $pass,$db);

    if (!$con)
    {
        die('Cannot connect to database.'. mysqli_connect_error());
    }

    function filteration($data)
    {
        foreach ($data as $key => $value){
            $value = trim($value);
            $value = stripslashes($value);
            $value = strip_tags($value);
            $value = htmlspecialchars($value);

            $data[$key] = $value;
            
        }
        return $data;
    }

    function selectAll($table)
    {
        $con = $GLOBALS['con'];
        $res = mysqli_query($con, "SELECT * FROM $table");
        return $res;
    }

    function select($sql, $values, $datatype)
    {
        $con = $GLOBALS['con'];
        if($stmt = mysqli_prepare($con, $sql))
        {
            mysqli_stmt_bind_param($stmt, $datatype, ...$values);
            if(mysqli_stmt_execute($stmt))
            {
                $res = mysqli_stmt_get_result($stmt);
                mysqli_stmt_close($stmt);
                
                return $res;
            }
            else{
                mysqli_stmt_close($stmt);
                die('Query cannot be executed - Select'. mysqli_error($con));
            }

        }
        else{
            die('Query cannot be executed - Select'. mysqli_error($con));
        }
    }

    function update($sql, $values, $datatype)
    {
        $con = $GLOBALS['con'];
        if($stmt = mysqli_prepare($con, $sql))
        {
            mysqli_stmt_bind_param($stmt, $datatype, ...$values);
            if(mysqli_stmt_execute($stmt))
            {
                $res = mysqli_stmt_affected_rows($stmt);
                mysqli_stmt_close($stmt);
                
                return $res;
            }
            else{
                mysqli_stmt_close($stmt);
                die('Query cannot be executed - Update'. mysqli_error($con));
            }

        }
        else{
            die('Query cannot be executed - Update'. mysqli_error($con));
        }
    }

    function insert($sql, $values, $datatype)
    {
        $con = $GLOBALS['con'];
        if($stmt = mysqli_prepare($con, $sql))
        {
            mysqli_stmt_bind_param($stmt, $datatype, ...$values);
            if(mysqli_stmt_execute($stmt))
            {
                $res = mysqli_stmt_affected_rows($stmt);
                mysqli_stmt_close($stmt);
                
                return $res;
            }
            else{
                mysqli_stmt_close($stmt);
                die('Query cannot be executed - Insert'. mysqli_error($con));
            }

        }
        else{
            die('Query cannot be executed - Insert'. mysqli_error($con));
        }
    }

    function delete($sql, $values, $datatype)
    {
        $con = $GLOBALS['con'];
        if($stmt = mysqli_prepare($con, $sql))
        {
            mysqli_stmt_bind_param($stmt, $datatype, ...$values);
            if(mysqli_stmt_execute($stmt))
            {
                $res = mysqli_stmt_affected_rows($stmt);
                mysqli_stmt_close($stmt);
                
                return $res;
            }
            else{
                mysqli_stmt_close($stmt);
                die('Query cannot be executed - Delete'. mysqli_error($con));
            }

        }
        else{
            die('Query cannot be executed - Delete'. mysqli_error($con));
        }
    }
?>