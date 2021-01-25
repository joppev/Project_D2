require('./bootstrap');



window.Noty = require('noty');
Noty.overrideDefaults({
    layout: 'center',
    theme: 'bootstrap-v4'
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
