<?php

function my_form($name, $lang = '', $type = '', $more = array(), $break = true) {
    echo form_error($name);
    echo form_label($lang);
    $default = '';
    if (is_array($more) and isset($more[$name])) {
        $default = $more[$name];
    } elseif (is_object($more) and isset($more->$name)) {
        $default = $more->$name;
    }
    if (empty($type)) {
        echo form_input(array('name' => $name, 'id' => $name, 'value' => set_value($name, $default)));
    }
    if ($type == 'password') {
        echo form_password(array('name' => $name, 'id' => $name, 'value' => set_value($name, $default)));
    } elseif ($type == 'text') {
        echo form_textarea(array('name' => $name, 'id' => $name, 'value' => set_value($name, $default)));
    } elseif ($type == 'tinymce') {
        echo '<textarea name="' . $name . '" id="tinyMCE" style="width: 50%; height: 500px;" id ="tinymce">'.  set_value($name, $default).'</textarea>';
    }
    if ($break) {
        echo '<br/>';
    }
}

function cleanHtmlTMC($string) {
    $start = strpos($string, 'body');
    $end = strrpos($string, 'body');
    
    return substr($string, $start + 8, ($end - $start - 13));
}

?>
