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
                    '!<%= webRoot %>/themes/templates/1/includes/js/bbcode.js'
                ]
            },
            needsCleanup: {
                src: [
                    // Specific target to run manually to work on cleaning up these
                    '<%= webRoot %>/themes/templates/1/includes/js/bbcode.js'
                ]
            }
        },

        lintspaces: {
            options: {
                editorconfig: '.editorconfig'
            },
            src: [
                '<%= webRoot %>/themes/templates/1/**/*.html',
                'Sources/styles/1/scss/*.scss',
                'Sources/styles/2/scss/*.scss',
                'Sources/styles/3/scss/*.scss',
                'Sources/styles/common/main_scss/**/*.scss'
            ]
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
                    '<%= webRoot %>php/main/**/*.php',
                    '<%= webRoot %>php/admin/**/*.php',
                    '<%= webRoot %>php/common/**/*.php',
                    '<%= webRoot %>php/config/*.php',
                    '<%= webRoot %>php/includes/*.php',
                    '<%= webRoot %>php/lib/*.php'
                ]
            },
            options: {
                standard: 'PSR2'
            }
        },
        phpcbf: {
            application: {
                src: [
                    '<%= webRoot %>php/main/**/*.php',
                    '<%= webRoot %>php/admin/**/*.php',
                    '<%= webRoot %>php/common/**/*.php',
                    '<%= webRoot %>php/config/*.php',
                    '<%= webRoot %>php/includes/*.php',
                    '<%= webRoot %>php/lib/*.php'
                ]
            },
            options: {
                standard: 'PSR2'
            }
        },
        csscomb: {
            dynamic_mappings: {
                expand: true,
                cwd: 'Sources/styles/1/scss/',
                src: ['*.scss'],
                dest: 'Sources/styles/1/scss/'
            },
            dynamic_mappings2: {
                expand: true,
                cwd: 'Sources/styles/2/scss/',
                src: ['*.scss'],
                dest: 'Sources/styles/2/scss/'
            },
            dynamic_mappings3: {
                expand: true,
                cwd: 'Sources/styles/3/scss/',
                src: ['*.scss'],
                dest: 'Sources/styles/3/scss/'
            },
            dynamic_mappings4: {
                expand: true,
                cwd: 'Sources/styles/common/main_scss/',
                src: ['*.scss'],
                dest: 'Sources/styles/common/main_scss/'
            }

        }

    });

    // Load the plugin that provides the "uglify" task.
    // grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-sass');
    grunt.loadNpmTasks('grunt-scss-lint');
    grunt.loadNpmTasks('grunt-pleeease');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-phpcs');
    grunt.loadNpmTasks('grunt-phpcbf');
    grunt.loadNpmTasks('grunt-sass-lint');
    grunt.loadNpmTasks('grunt-eslint');
    grunt.loadNpmTasks('grunt-lintspaces');
    grunt.loadNpmTasks('grunt-csscomb');

    // Default task(s).
    grunt.registerTask('default', ['eslint:application', 'lintspaces', 'sass', 'pleeease', 'phpcbf']);
    grunt.registerTask('lint', ['scsslint']);
    grunt.registerTask('sass-lint', ['sasslint']);
    grunt.registerTask('css-fix', ['csscomb']);
    grunt.registerTask('phpcheck', ['phpcs']);
    grunt.registerTask('phpfix', ['phpcbf']);
};
