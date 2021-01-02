/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

require("@fortawesome/fontawesome-free/css/all.min.css");
require("@fortawesome/fontawesome-free/js/all.js");

// any CSS you import will output into a single css file (app.css in this case)
import "./styles/app.css";

// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
// import $ from 'jquery';

console.log("Hello Webpack Encore! Edit me in assets/app.js");

const $ = require("jquery");
// this "modifies" the jquery module: adding behavior to it
// the bootstrap module doesn't export/return anything
require("bootstrap");

// or you can include specific pieces
// require('bootstrap/js/dist/tooltip');
// require('bootstrap/js/dist/popover');

$(document).ready(function () {
  $('[data-toggle="popover"]').popover();
});

$(".carousel").carousel();

console.log("test js");

$("#add_photo1").on("click", function (event) {
  $("#photo1").show();
  $("#add_photo1").hide();
  $("#add_photo2").show();
});

$("#add_photo2").on("click", function (event) {
  if ($("#url1").val() != "") {
    $("#photo2").show();
    $("#add_photo2").hide();
    $("#supp1").hide();
    $("#supp2").show();
    $("#add_photo3").show();
  }
});

$("#add_photo3").on("click", function (event) {
  if ($("#url2").val() != "") {
    $("#photo3").show();
    $("#supp2").hide();
    $("#supp3").show();
    $("#add_photo3").hide();
  }
});

$("#add_photoupdate3").on("click", function (event) {
  $("#photo3").show();
  $("#add_photoupdate3").hide();
});

$("#supp1").on("click", function (event) {
  $("#photo1").hide();
  $("#updatephoto1").hide();
  $("#url1").val("");
  $("#add_photo1").show();
  $("#add_photo2").hide();
});

$("#supp2").on("click", function (event) {
  $("#photo2").hide();
  $("#updatephoto2").hide();
  $("#url2").val("");
  $("#add_photo2").show();
  $("#supp1").show();
  $("#add_photo3").hide();
});

$("#supp3").on("click", function (event) {
  $("#photo3").hide();
  $("#updatephoto3").hide();
  $("#url3").val("");
  $("#add_photo3").show();
  $("#supp2").show();
});

$("#add_video1").on("click", function (event) {
  $("#video1").show();
  $("#add_video1").hide();
  $("#add_video2").show();
});

$("#add_video2").on("click", function (event) {
  if ($("#urlvideo1").val() != "") {
    $("#video2").show();
    $("#add_video2").hide();
    $("#suppvideo1").hide();
    $("#suppvideo2").show();
    $("#add_video3").show();
  }
});

$("#add_video3").on("click", function (event) {
  if ($("#urlvideo2").val() != "") {
    $("#video3").show();
    $("#suppvideo2").hide();
    $("#suppvideo3").show();
    $("#add_video3").hide();
  }
});

$("#add_photoupdate3").on("click", function (event) {
  $("#photo3").show();
  $("#add_photoupdate3").hide();
});

$("#suppvideo1").on("click", function (event) {
  $("#video1").hide();
  $("#updatephoto1").hide();
  $("#urlvideo1").val("");
  $("#add_video1").show();
  $("#add_video2").hide();
});

$("#suppvideo2").on("click", function (event) {
  $("#video2").hide();
  $("#updatevideo2").hide();
  $("#urlvideo2").val("");
  $("#add_video2").show();
  $("#suppvideo1").show();
  $("#add_video3").hide();
});

$("#suppvideo3").on("click", function (event) {
  $("#video3").hide();
  $("#updatevideo3").hide();
  $("#urlvideo3").val("");
  $("#add_video3").show();
  $("#suppvideo2").show();
});

$("#delete_trick").on("shown.bs.modal", function (event) {
  const button = $(event.relatedTarget);
  const id = button.data("id");
  $("#footer-delete").html(
    '<button type="button" class="btn btn-secondary p-2" style="font-size: 10px;" data-dismiss="modal">Non</button><a type="button" href ="/trick/delete?id=' +
      id +
      '" class="btn btn-danger p-2" style="font-size: 10px;">Oui</a>'
  );
});
