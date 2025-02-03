import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
// resources/js/bootstrap.js
import $ from 'jquery';
import * as bootstrap from 'bootstrap';

// Misalnya, untuk mengaktifkan dropdown, pastikan event listener ditambahkan
$(document).ready(function() {
  // Menginisialisasi semua dropdown Bootstrap
  var dropdownElements = document.querySelectorAll('.dropdown-toggle');
  dropdownElements.forEach(function(dropdown) {
    new bootstrap.Dropdown(dropdown);
  });
});
