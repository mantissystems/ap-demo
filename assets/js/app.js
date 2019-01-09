// loads the Bootstrap jQuery plugins
import 'bootstrap-sass/assets/javascripts/bootstrap/transition.js';
import 'bootstrap-sass/assets/javascripts/bootstrap/alert.js';
import 'bootstrap-sass/assets/javascripts/bootstrap/collapse.js';
import 'bootstrap-sass/assets/javascripts/bootstrap/dropdown.js';
import 'bootstrap-sass/assets/javascripts/bootstrap/modal.js';
import 'jquery'

let Routing = require('../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.js')
let Routes = require('./js/js_routes.json')
Routing.setRoutingData(Routes)
console.log(Routing)
// loads the code syntax highlighting library
import './highlight.js';

// Creates links to the Symfony documentation
import './doclinks.js';
