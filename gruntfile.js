module.exports = function (grunt) {
  grunt.initConfig({
    // Watch task config
    watch: {
        styles: {
            files: "css/*.scss",
            tasks: ['sass', 'postcss'],
        },
        javascript: {
            files: ["js/*.js", "!js/*.min.js"],
            tasks: ['uglify'],
        },
    },
    sass: {
        dev: {
            files: {
                "css/style.min.css" : "css/style.scss",
            }
        }
    },
    postcss: {
        options: {
            map: {
                inline: false,
            },

            processors: [
                require('pixrem')(), // add fallbacks for rem units
                require('autoprefixer')({browsers: 'last 2 versions'}), // add vendor prefixes
                require('cssnano')() // minify the result
            ]
        },
        dist: {
            src: 'css/*.min.css',
        }
    },
    browserSync: {
        dev: {
            bsFiles: {
                src : ['css/*.min.css', '**/*.php', '**/*.js', '**/*.svg', '**/*.html', '!node_modules'],
            },
            options: {
                watchTask: true,
                proxy: "https://dev.wordpress.dev",
                https: {
                    key: "/Users/andrew/github/dotfiles/local-dev.key",
                    cert: "/Users/andrew/github/dotfiles/local-dev.crt",
                }
            },
        },
    },
    uglify: {
        custom: {
            files: {
            },
        },
    },
  });

    grunt.loadNpmTasks('grunt-sass');
    grunt.loadNpmTasks('grunt-postcss');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-browser-sync');
    grunt.registerTask('default', [
        'browserSync',
        'watch',
    ]);
};
