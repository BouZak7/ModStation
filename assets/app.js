import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.css';

console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');

let profil = document.getElementById("profil")

// profil.addEventListener("click", () => {
//     console.log('test') 
//     profil.setAttribute("class", 'hidden')
// })