import "./bootstrap";
import "../css/app.css";

import { Calendar } from "@fullcalendar/core";
import dayGridPlugin from "@fullcalendar/daygrid";

import flatpickr from "flatpickr";
import "flatpickr/dist/flatpickr.min.css";

import "flowbite";

import { DataTable } from "simple-datatables";

import $ from "jquery";

import Swal from "sweetalert2";

import toastr from "toastr";
import "toastr/build/toastr.min.css";

import Alpine from "alpinejs";
import persist from "@alpinejs/persist";

Alpine.plugin(persist);
window.Alpine = Alpine;

window.Calendar = Calendar;
window.dayGridPlugin = dayGridPlugin;

window.flatpickr = flatpickr;

window.simpleDatatables = { DataTable };

window.$ = $;
window.jQuery = $;

window.Swal = Swal;

window.toastr = toastr;

Alpine.start();
