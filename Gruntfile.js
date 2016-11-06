module.exports = function(grunt) {

  // Project configuration.
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    sass: {
        options: {
            sourceMap: true
            },
            dist: {
                files: {
                    'Website/AtariLegend/themes/styles/1/css/style.css': 'Website/AtariLegend/themes/styles/1/scss/style.scss'
                }
            },
            dist2: {
                files: {
                    'Website/AtariLegend/themes/styles/2/css/style.css': 'Website/AtariLegend/themes/styles/2/scss/style.scss'
                }
            },
            dist3: {
                files: {
                    'Website/AtariLegend/themes/styles/3/css/style.css': 'Website/AtariLegend/themes/styles/3/scss/style.scss'
                }
            }
        },

      scsslint: {
    allFiles: [
      'Website/AtariLegend/themes/styles/1/scss/*.scss',
      'Website/AtariLegend/themes/styles/2/scss/*.scss',
      'Website/AtariLegend/themes/styles/3/scss/*.scss',
    ],
    options: {
      bundleExec: false,
      config: '.scss-lint.yml',
      reporterOutput: 'result/scss-lint-report.xml',
      colorizeOutput: true,
      SelectorFormat: 'snake_case',
      maxBuffer: 3000000 * 1024
    },
  },

  pleeease: {
    custom: {
      options: {
        autoprefixer: {'browsers': ['last 4 versions', 'ios 6']},
        filters: {'oldIE': true},
        rem: ['12px'],
        minifier: true,
        mqpacker: true,
        pseudoElements: true,
      },
      files: {
        'Website/AtariLegend/themes/styles/1/css/style.css': 'Website/AtariLegend/themes/styles/1/css/style.css',
        'Website/AtariLegend/themes/styles/2/css/style.css': 'Website/AtariLegend/themes/styles/2/css/style.css',
        'Website/AtariLegend/themes/styles/3/css/style.css': 'Website/AtariLegend/themes/styles/3/css/style.css'
      }
    }
  },

    watch: {
      sass: {
        files: [
            'Website/AtariLegend/themes/styles/1/scss/*.scss',
            'Website/AtariLegend/themes/styles/2/scss/*.scss',
            'Website/AtariLegend/themes/styles/3/scss/*.scss'
        ],
        tasks: ['default']
      },
    },

    phpcs: {
    application: {
        src: [
                //'Website/AtariLegend/php/admin/menus/ajax_adddocs_menus.php',
                'Website/AtariLegend/php/main/**/*.php'
        ]
    },
    options: {
        bin: '/usr/bin/phpcs -d memory_limit=128M',
        standard: 'PSR2',
        reportFile: 'result/report.txt',
        verbose: true,
        maxBuffer: 10000000000*2048,
    }
    },

  stylizeSCSS: {
    target: {
      options: {
            tabSize: 4,
            extraLine: true,
            oneLine: true,
            cleanZeros: true
      },

      files: [{
        expand: true,
        src: [
            'Website/AtariLegend/themes/styles/1/scss/*.scss',
            'Website/AtariLegend/themes/styles/2/scss/*.scss',
            'Website/AtariLegend/themes/styles/3/scss/*.scss'],
        dest: 'result/scss/'
      }]
    },
  }

    });

    // Load the plugin that provides the "uglify" task.
    //grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-sass');
    grunt.loadNpmTasks('grunt-scss-lint');
    grunt.loadNpmTasks('grunt-scss-stylize');
    grunt.loadNpmTasks('grunt-pleeease');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-phpcs');

    // Default task(s).
    grunt.registerTask('default', ['sass','pleeease']);
    grunt.registerTask('lint', ['scsslint']);
    grunt.registerTask('beauty', ['stylizeSCSS']);
    grunt.registerTask('phpcheck', ['phpcs']);
};
