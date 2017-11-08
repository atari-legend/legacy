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
                    'Website/AtariLegend/themes/styles/1/css/style.css': 'Sources/styles/1/scss/style.scss'
                }
            },
            dist2: {
                files: {
                    'Website/AtariLegend/themes/styles/2/css/style.css': 'Sources/styles/2/scss/style.scss'
                }
            },
            dist3: {
                files: {
                    'Website/AtariLegend/themes/styles/3/css/style.css': 'Sources/styles/3/scss/style.scss'
                }
            }
        },

    scsslint: {
        allFiles: [
            'Sources/styles/1/scss/*.scss',
            'Sources/styles/2/scss/*.scss',
            'Sources/styles/3/scss/*.scss',
            'Sources/styles/common/main_scss/**/*.scss',
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

    sasslint: {
        options: {
            configFile: '.sass-lint.yml',
            formatter: 'stylish'
        },
        target: [
            'Sources/styles/1/scss/*.scss',
            'Sources/styles/2/scss/*.scss',
            'Sources/styles/3/scss/*.scss',
            'Sources/styles/common/main_scss/**/*.scss',
        ]
    },


  pleeease: {
    custom: {
      options: {
        autoprefixer: {'browsers': ['last 4 versions', 'ios 6']},
        filters: {'oldIE': true},
        rem: ['12px'],
        opacity: true,
        minifier: true,
        mqpacker: false,
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
            'Sources/styles/1/scss/*.scss',
            'Sources/styles/2/scss/*.scss',
            'Sources/styles/3/scss/*.scss',
            'Sources/styles/common/main_scss/**/*.scss'
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
            'Sources/styles/1/scss/*.scss',
            'Sources/styles/2/scss/*.scss',
            'Sources/styles/3/scss/*.scss',
            'Sources/styles/common/main_scss/**/*.scss'
        ],
        dest: 'result/scss/'
      }]
    },

},
    stylefmt: {
    format: {
        options: {
            syntax: 'scss'
        },
        files: {
             'result/fix/scss/': ['Sources/styles/1/scss/*.scss']
      }
    },
  },


    });

    // Load the plugin that provides the "uglify" task.
    //grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-sass');
    grunt.loadNpmTasks('grunt-scss-lint');
    grunt.loadNpmTasks('grunt-scss-stylize');
    grunt.loadNpmTasks('grunt-pleeease');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-phpcs');
    grunt.loadNpmTasks('grunt-sass-lint');
    grunt.loadNpmTasks('grunt-stylefmt');
    grunt.loadNpmTasks('grunt-stylelint');

    // Default task(s).
    grunt.registerTask('default', ['sass','pleeease']);
    grunt.registerTask('lint', ['scsslint']);
    grunt.registerTask('sass-lint', ['sasslint']);
    grunt.registerTask('beauty', ['stylizeSCSS']);
    grunt.registerTask('css-fix', ['stylefmt']);
    grunt.registerTask('phpcheck', ['phpcs']);
};
