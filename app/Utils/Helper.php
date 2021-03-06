<?php


function errors($errors)
{

    if ($errors->count() > 0) {
        echo "<div style='direction:ltr;' class='alert alert-danger red danger-errors'";
        echo "<p style='margin-right:10px;'>";
        foreach ($errors->all() as $error) {
            echo "<span style='vertical-align: text-bottom;'>•</span> &nbsp; &nbsp;" . $error;
            echo "<br/>";
        }
        echo "</p>";
        echo "</div>";
    }
}

function message($msg)
{
    echo "<div style='direction:ltr;text-align: left' class='alert alert-success green'>" . (Session::get('msg') == '' ? $msg : Session::get('msg')) . "</div>";
}
