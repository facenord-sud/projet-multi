<?php

function my_form($name, $lang = '', $type = '', $more = array(), $break = true) {
    echo form_error($name);
    echo $lang;
    if (empty($type)) {
        echo form_input(array('name' => $name, 'id' => $name, 'value' => set_value($name)));
    }
    if ($type == 'password') {
        echo form_password(array('name' => $name, 'id' => $name, 'value' => set_value($name)));
    }
    if ($break) {
        echo '<br/>';
    }
}

?>
