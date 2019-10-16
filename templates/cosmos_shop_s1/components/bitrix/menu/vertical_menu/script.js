$(document).ready(function(){
    $('.widget-vertical-menu li.parent-item i.icon-angle-right, .widget-vertical-menu li.parent-item i.icon-angle-down').click(function(){
        $(this).toggleClass("icon-angle-right icon-angle-down");
        $(this).parent().toggleClass("root-item-selected root-item");
    });
    $('.item-selected').parent().parent().find('i:first').click();
});