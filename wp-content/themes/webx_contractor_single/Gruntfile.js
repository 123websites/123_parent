module.exports = function(grunt) {

  // Project configuration.
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    sass: {
      dist: {
        files: {
          'build/css/build.css' : 'sass/main.scss',
        },
      },
      login: {
        files: {
          'build/css/login.css' : 'sass/login.scss',
        },
      },
    },
    concat: {
      options: {
        separator: '\n',
      },
      js: {
        src: ['js_vendor/jquery-1.12.4.min.js', '../../../wp-includes/js/masonry.min.js', 'js_vendor/lity.min.js', 'js_vendor/baguetteBox.min.js', 'js_vendor/ofi.browser.js', 'js/**/*.js'],
        dest: 'build/js/build.js',
      },
      css: {
        src: ['node_modules/font-awesome/css/font-awesome.min.css', 'build/css/build.css'],
        dest: 'build/css/build.css',
      },
    },
    watch: {
      sass: {
        files: ['sass/**/*.scss'],
        tasks: ['sass'],
        options: {
          livereload : 35729
        },
      },
      js: {
        files: ['js/**/*.js'],
        tasks: ['concat'],
        options: {
          livereload : 35729
        },
      },
      php: {
        files: ['**/*.php'],
        options: {
          livereload : 35729
        },
      },
      options: {
        style: 'expanded',
        compass: true,
      },
    },
  });

  
  grunt.loadNpmTasks('grunt-contrib-sass');
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-watch');

  grunt.registerTask('default', ['sass', 'concat', 'watch']);
 

};