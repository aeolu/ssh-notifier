module.exports = function(grunt) {

    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        shell: {
            phpunit: {
                command: 'phpunit'
            },
            clear: {
                command: 'clear'
            },
            phpcs: {
                command: 'phpcs --standard=PSR2 ./src'
            }
        },

        watch: {
            phpunit: {
                files: ['src/**/*.php', 'tests/**/*.php'],
                tasks: ['shell:clear', 'shell:phpcs', 'shell:phpunit']
            },
        }

    });

    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-shell');

    grunt.registerTask('phpunit',  ['watch:phpunit']);
    grunt.registerTask('default',  ['watch']);
}
