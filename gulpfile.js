// 1️⃣ Require modules
const { src, dest, watch, series } = require('gulp');
const browserSync = require('browser-sync').create();
const sass = require('gulp-sass')(require('sass')); // Si usas SASS
const plumber = require('gulp-plumber');
const { deleteAsync } = require('del');

// 2️⃣ Additional modules for JS
const sourcemaps = require('gulp-sourcemaps');
const concat = require('gulp-concat');
const terser = require('gulp-terser-js');

// 3️⃣ Rutas de archivos
const paths = {
    scss: 'src/scss/**/*.scss',
    js: 'src/js/**/*.js',
    vendorJs: [
        'node_modules/jquery/dist/jquery.min.js',
        'node_modules/bootstrap/dist/js/bootstrap.bundle.min.js',
        'node_modules/datatables.net/js/dataTables.min.js',
        'node_modules/datatables.net-bs5/js/dataTables.bootstrap5.min.js'
    ],
    vendorCss: [
        'node_modules/normalize.css/normalize.css',
        'node_modules/bootstrap/dist/css/bootstrap.min.css',
        'node_modules/datatables.net-bs5/css/dataTables.bootstrap5.min.css'
    ]
};

// 4️⃣ Ruta base para el proxy
let currentProxy = 'http://localhost:3001'; // SINGLE PHP PORT

// 5️⃣ Recarga navegador
function reload(done) {
  browserSync.reload();
  done();
}

// 6️⃣ Limpiar directorios
function cleanCss() {
  return deleteAsync('./public/build/css');
}

function cleanJs() {
  return deleteAsync('./public/build/js');
}

// 7️⃣ Procesar y compilar archivos
function compileSass() {
  return src('src/scss/app.scss')
    .pipe(plumber())
    .pipe(sass())
    .pipe(dest('public/build/css'))
    .pipe(browserSync.stream());
}

function compileBoSidebar() {
  return src('src/scss/bo-sidebar-only.scss')
    .pipe(plumber())
    .pipe(sass())
    .pipe(dest('public/build/css'))
    .pipe(browserSync.stream());
}

function processJs() {
    // Compilar app.js (excluyendo los filtros que se compilan por separado)
    const appJs = src(['src/js/app.js'])
        .pipe(sourcemaps.init())
        .pipe(terser())
        .pipe(sourcemaps.write('.'))
        .pipe(dest('public/build/js'));
    
    // Compilar animals-filter.js por separado
    const animalsFilterJs = src('src/js/animals-filter.js')
        .pipe(sourcemaps.init())
        .pipe(terser())
        .pipe(sourcemaps.write('.'))
        .pipe(dest('public/build/js'));
    
    // Compilar habitat-filter.js por separado
    const habitatFilterJs = src('src/js/habitat-filter.js')
        .pipe(sourcemaps.init())
        .pipe(terser())
        .pipe(sourcemaps.write('.'))
        .pipe(dest('public/build/js'));
    
    // Compilar rating-testimony.js por separado
    const ratingTestimonyJs = src('src/js/rating-testimony.js')
        .pipe(sourcemaps.init())
        .pipe(terser())
        .pipe(sourcemaps.write('.'))
        .pipe(dest('public/build/js'));
    
    // Retornar todos los streams en paralelo
    return require('merge-stream')(appJs, animalsFilterJs, habitatFilterJs, ratingTestimonyJs);
}

function copyVendorJs() {
    return src(paths.vendorJs)
        .pipe(dest('public/build/js'));
}

function copyVendorCss() {
    return src(paths.vendorCss)
        .pipe(dest('public/build/css'));
}

// 8️⃣ Tareas combinadas
const buildCss = series(cleanCss, compileSass, compileBoSidebar, copyVendorCss);
const buildJs = series(cleanJs, processJs, copyVendorJs);

// Exportar tareas para uso en Dockerfile
exports.buildCss = buildCss;
exports.buildJs = buildJs;

// 9️⃣ Servidor con Browsersync
function serve(done) {
  browserSync.init({
    proxy: currentProxy,
    open: true,
    notify: true
  });
  done();
}

// 🔟 UNIQUE AND POWERFUL Watcher
function watchAll() {
  // Estilos y JS
  watch(paths.scss, buildCss);
  watch(paths.js, series(buildJs, reload));
  
  // PHP (Frontend y Backend unificados)
  watch('public/**/*.php', reload);
  watch('App/**/*.php', reload);
  watch('includes/**/*.php', reload);
}

// 1️⃣1️⃣ DEFAULT TASK
// Al llamar 'exports.default', Gulp sabe que esta es la tarea que debe ejecutar si solo escribes 'gulp'
exports.default = series(buildCss, buildJs, serve, watchAll);
