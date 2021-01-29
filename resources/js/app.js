//require('./require');
require('./bootstrap');
//require('./qlikFile');



window.Noty = require('noty');
Noty.overrideDefaults({
    theme: 'bootstrap-v4',
    type: 'warning',
    layout: 'center',
    modal: true,
});
import Project2d from "./project2d";
window.Project2d = Project2d;



$(function () {
    $('nav i.fas').addClass('fa-fw mr-1');
    $('body').tooltip({
        selector: '[data-toggle="tooltip"]',
        html : true,
    }).on('click', '[data-toggle="tooltip"]', function () {
        // hide tooltip when you click on it
        $(this).tooltip('hide');
    });
});
$(function(){
    $('[required]').each(function () {
        $(this).closest('.form-group')
            .find('label')
            .append('<sup class="text-danger mx-1">*</sup>');
    });
});
