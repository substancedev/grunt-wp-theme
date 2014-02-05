'use strict';

/*
var LIVERELOAD_PORT = 35729;
var lrSnippet = require('connect-livereload')({
	port: LIVERELOAD_PORT
});
var mountFolder = function (connect, dir) {
	return connect.static(require('path').resolve(dir));
};
*/

module.exports = function( grunt ) {

	// Load all grunt tasks
	require('matchdep').filterDev('grunt-*').forEach(grunt.loadNpmTasks);

	// Project configuration
	grunt.initConfig( {
		pkg: grunt.file.readJSON( 'package.json' ),
		dirs: {
			bower: './bower_components',
			assets: './assets',
			css: '<%= dirs.assets %>/css',
			{% if ('sass' === css_type) { %}
			sass: '<%= dirs.css %>/sass',
			{% } else if ('less' === css_type) { %}
			less: '<%= dirs.css %>/less',
			{% } %}
			js: '<%= dirs.assets %>/js',
			vendor: '<%= dirs.assets %>/vendor'
		},
		connect: {
			options: {
				port: 9191,
				hostname: '*'
			},
			livereload: {
				options: {
					middleware: function (connect) {
						return [lrSnippet, mountFolder(connect, 'app')];
					}
				}
			}
		},
		bower: {
			install: {
				options: {
					cleanup: true,
					copy: true,
					install: true,
					layout: 'byType',
					targetDir: '<%= dirs.vendor %>'
				}
			}
		},
		concat: {
			options: {
				stripBanners: true,
				banner: '/*! <%= pkg.title %> - v<%= pkg.version %> - <%= grunt.template.today("yyyy-mm-dd") %>\n' +
					' * <%= pkg.homepage %>\n' +
					' * Copyright (c) <%= grunt.template.today("yyyy") %>;' +
					' */\n'
			},
			head: {
				src: [
					'<%= dirs.js %>/src/head.js'
				],
				dest: '<%= dirs.js %>/head.js'
			},
			{%= js_safe_name %}: {
				src: [
					'<%= dirs.js %>/src/{%= js_safe_name %}.js'
				],
				dest: '<%= dirs.js %>/{%= js_safe_name %}.js'
			},
			oldIE : {
				src: [
				
				],
				dest: '<%= dirs.js %>/ie.js'
			}
		},
		jshint: {
			browser: {
				all: [
					'<%= dirs.js %>/src/**/*.js',
					'<%= dirs.js %>/test/**/*.js'
				],
				options: {
					jshintrc: '.jshintrc'
				}
			},
			grunt: {
				all: [
					'Gruntfile.js'
				],
				options: {
					jshintrc: '.gruntjshintrc'
				}
			}
		},
		uglify: {
			all: {
				files: {
					'<%= dirs.js %>/head.min.js': ['<%= dirs.js %>/head.js'],
					'<%= dirs.js %>/{%= js_safe_name %}.min.js': ['<%= dirs.js %>/{%= js_safe_name %}.js']
				},
				options: {
					banner: '/*! <%= pkg.title %> - v<%= pkg.version %> - <%= grunt.template.today("yyyy-mm-dd") %>\n' +
						' * <%= pkg.homepage %>\n' +
						' * Copyright (c) <%= grunt.template.today("yyyy") %>;' +
						' */\n',
					mangle: {
						except: ['jQuery']
					}
				}
			}
		},
		test:	 {
			files: ['<%= dirs.js %>/test/**/*.js']
		},
		{% if ('sass' === css_type) { %}
		sass:	 {
			options: {
				compass: false,
				loadPath: [
					'<%= dirs.vendor %>/scss'
				]
			},
			all: {
				files: {
					'<%= dirs.css %>/{%= js_safe_name %}.css': '<%= dirs.sass %>/{%= js_safe_name %}.scss'
				}
			}
		},
		{% } else if ('less' === css_type) { %}
		less:	 {
			all: {
				files: {
					'<%= dirs.css %>/{%= js_safe_name %}.css': '<%= dirs.less %>/{%= js_safe_name %}.less'
				}
			}
		},
		{% } %}
		cssmin: {
			options: {
				banner: '/*! <%= pkg.title %> - v<%= pkg.version %> - <%= grunt.template.today("yyyy-mm-dd") %>\n' +
					' * <%= pkg.homepage %>\n' +
					' * Copyright (c) <%= grunt.template.today("yyyy") %>;' +
					' */\n'
			},
			minify: {
				expand: true,
				{% if ('sass' === css_type || 'less' === css_type) { %}
				cwd: '<%= dirs.css %>/',
				src: ['{%= js_safe_name %}.css'],
				{% } else { %}
				cwd: '<%= dirs.css %>/src/',
				src: ['{%= js_safe_name %}.css'],
				{% } %}
				dest: '<%= dirs.css %>/',
				ext: '.min.css'
			}
		},
		watch:	{
			options: {
				livereload: true,
				files: ['<%= dirs.css %>/*.css']
			},
			markup: {
				files: ['*.html','*.php','includes/*.php','partials/*.php']
			},
			{% if ('sass' === css_type) { %}
			sass: {
				files: ['<%= dirs.sass %>/**/*.scss'],
				tasks: ['sass', 'cssmin']
			},
			{% } else if ('less' === css_type) { %}
			less: {
				files: ['<%= dirs.less %>/**/*.less'],
				tasks: ['less', 'cssmin']
			},
			{% } else { %}
			styles: {
				files: ['<%= dirs.css %>/src/*.css'],
				tasks: ['cssmin']
			},
			{% } %}
			scripts: {
				files: ['<%= dirs.js %>/src/**/*.js', '<%= dirs.vendror/**/*.js'],
				tasks: ['jshint', 'concat', 'uglify']
			}
		}
	} );

	// Default task.
	{% if ('sass' === css_type) { %}
	grunt.registerTask( 'default', ['bower', 'jshint', 'concat', 'uglify', 'sass', 'cssmin'] );
	{% } else if ('less' === css_type) { %}
	grunt.registerTask( 'default', ['bower', 'jshint', 'concat', 'uglify', 'less', 'cssmin'] );
	{% } else { %}
	grunt.registerTask( 'default', ['bower', 'jshint', 'concat', 'uglify', 'cssmin'] );
	{% } %}

	grunt.util.linefeed = '\n';
};