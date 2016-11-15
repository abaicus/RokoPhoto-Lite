/* jshint node:true */
// https://github.com/gruntjs/grunt-contrib-jshint

module.exports = {
    options:{
        jshintrc:true,
        reporterOutput:'<%= paths.logs %>jslogs.log',
    },
    all: [
        '<%= files.js %>',
        '!js/bootstrap.js',
        '!js/cbpAnimatedHeader.js',
        '!js/classie.js',
        '!js/modernizr.custom.js',
        '!js/SmoothScroll.js',
        '!js/html5shiv.js',
        '!js/jquery.easing.js',
        '!js/respond.js',
        '!js/wow.js',
        '!Gruntfile.js'
    ]

};