tinyMCE.init({
    theme : "advanced",
    plugins : "fullpage",
    file_browser_callback : "filebrowser",
    theme_advanced_buttons3_add : "fullpage",
    mode : "exact",
    elements : "tinyMCE"
});

function filebrowser(field_name, url, type, win) {
    
    //    fileBrowserURL = "/ojneuveville/pdw_file_browser/index.php?editor=tinymce&filter=" + type;
    fileBrowserURL = "/2012/montmoln/projet/www/tinymce/file_gestionary/index.php";
    //      
    tinyMCE.activeEditor.windowManager.open({
        title: "PDW File Browser",
        url: fileBrowserURL,
        width: 950,
        height: 650,
        inline: 0,
        maximizable: 1,
        close_previous: 0
    },{
        window : win,
        input : field_name
    }
    )
    };