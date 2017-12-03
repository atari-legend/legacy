module.exports = function (grunt) {
    // Project configuration.
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        webRoot: 'Website/AtariLegend/',

        sass: {
            options: {
                sourceMap: true
            },
            dist: {
                files: {
                    '<%= webRoot %>themes/styles/1/css/style.css': 'Sources/styles/1/scss/style.scss'
                }
            },
            dist2: {
                files: {
                    '<%= webRoot %>themes/styles/2/css/style.css': 'Sources/styles/2/scss/style.scss'
                }
            },
            dist3: {
                files: {
                    '<%= webRoot %>themes/styles/3/css/style.css': 'Sources/styles/3/scss/style.scss'
                }
            }
        },

        eslint: {
            application: {
                src: [
                    'Gruntfile.js',
                    '<%= webRoot %>/themes/templates/1/includes/js/*.js',
                    // For now ignore some files that need cleanup
                    '!<%= webRoot %>/themes/templates/1/includes/js/bbcode.js',
                    '!<%= webRoot %>/themes/templates/1/includes/js/menus.js'
                ]
            },
            needsCleanup: {
                src: [
                    // Specific target to run manually to work on cleaning up these
                    '<%= webRoot %>/themes/templates/1/includes/js/bbcode.js',
                    '<%= webRoot %>/themes/templates/1/includes/js/menus.js'
                ]
            }
        },

        lintspaces: {
            options: {
                editorconfig: '.editorconfig'
            },
            src: ['<%= webRoot %>/themes/templates/1/**/*.html']
        },

        scsslint: {
            allFiles: [
                'Sources/styles/1/scss/*.scss',
                'Sources/styles/2/scss/*.scss',
                'Sources/styles/3/scss/*.scss',
                'Sources/styles/common/main_scss/**/*.scss'
            ],
            options: {
                bundleExec: false,
                config: '.scss-lint.yml',
                reporterOutput: 'result/scss-lint-report.xml',
                colorizeOutput: true,
                SelectorFormat: 'snake_case',
                maxBuffer: 3000000 * 1024
            }
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
                'Sources/styles/common/main_scss/**/*.scss'
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
                    pseudoElements: true
                },
                files: {
                    '<%= webRoot %>themes/styles/1/css/style.css': '<%= webRoot %>themes/styles/1/css/style.css',
                    '<%= webRoot %>themes/styles/2/css/style.css': '<%= webRoot %>themes/styles/2/css/style.css',
                    '<%= webRoot %>themes/styles/3/css/style.css': '<%= webRoot %>themes/styles/3/css/style.css'
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
            }
        },

        phpcs: {
            application: {
                src: [
                    // '<%= webRoot %>php/admin/menus/ajax_adddocs_menus.php',
                    '<%= webRoot %>php/main/**/*.php'
                ]
            },
            options: {
                standard: 'PSR2'
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
            }

        },
        stylefmt: {
            format: {
                options: {
                    syntax: 'scss'
                },
                files: {
                    'result/fix/scss/': ['Sources/styles/1/scss/*.scss']
                }
            }
        }

    });

    // Load the plugin that provides the "uglify" task.
    // grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-sass');
    grunt.loadNpmTasks('grunt-scss-lint');
    grunt.loadNpmTasks('grunt-scss-stylize');
    grunt.loadNpmTasks('grunt-pleeease');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-phpcs');
    grunt.loadNpmTasks('grunt-sass-lint');
    grunt.loadNpmTasks('grunt-stylefmt');
    grunt.loadNpmTasks('grunt-stylelint');
    grunt.loadNpmTasks('grunt-eslint');
    grunt.loadNpmTasks('grunt-lintspaces');

    // Default task(s).
    grunt.registerTask('default', ['eslint:application', 'lintspaces', 'sass', 'pleeease']);
    grunt.registerTask('lint', ['scsslint']);
    grunt.registerTask('sass-lint', ['sasslint']);
    grunt.registerTask('beauty', ['stylizeSCSS']);
    grunt.registerTask('css-fix', ['stylefmt']);
    grunt.registerTask('phpcheck', ['phpcs']);
};
