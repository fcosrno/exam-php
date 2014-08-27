var gulp = require('gulp'),
    sys = require('sys'),
    exec = require('child_process').exec;

gulp.task('phpunit', function() {
    exec('phpunit --colors --bootstrap vendor/autoload.php tests/', function(error, stdout) {
        sys.puts(stdout);
    });
});

gulp.task('default', function() {
    gulp.watch('**/*.php', { debounceDelay: 2000 }, ['phpunit']);
});