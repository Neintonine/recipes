import "../../../scss/common/common.scss";
import "@eonasdan/tempus-dominus/src/scss/tempus-dominus.scss";
import Tags from "bootstrap5-tags";
import {DateTime, TempusDominus} from "@eonasdan/tempus-dominus";
import $ from "jquery";
import { Dropdown } from "bootstrap";
window.Dropdown = Dropdown;
require("bootstrap-select");

document.addEventListener("DOMContentLoaded", () => {

    Tags.init("select#tag-input", {
        allowNew: true
    });

    const $selects = $("select.selectpicker");
    $selects.selectpicker();

    const defaultDate = new DateTime();
    defaultDate.setFullYear(2000, 0, 0);
    defaultDate.setHours(0,0,0,0);
    const tempusDominus = new TempusDominus(document.getElementById("prepration-time-input"), {
        useCurrent: false,
        defaultDate: defaultDate,
        display: {
            components: {
                calendar: false,

            }
        },
        localization: {
            format: "HH:mm",
            hourCycle: "h23"
        }
    })
})