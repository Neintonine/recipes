import "../../../scss/common/common.scss";
import "@eonasdan/tempus-dominus/src/scss/tempus-dominus.scss";
import Tags from "bootstrap5-tags";
import {DateTime, TempusDominus} from "@eonasdan/tempus-dominus";
import $ from "jquery";
import { Dropdown } from "bootstrap";
window.Dropdown = Dropdown;
require("bootstrap-select");

document.addEventListener("DOMContentLoaded", () => {

    const INGREDIENT_TABLE = document.querySelector("table.js-ingredient-table");

    function tpl() {
        return `
<tr>
    <td><i class="fa-solid fa-bars"></i></td>
    <td><input type="number" class="form-control"></td>
    <td>
        <select>
        </select>
    </td>
    <td>
        <i class="text-danger fa-solid fa-xmark"></i>
    </td>
</tr>`;
    }
    document.querySelector(".js-add-ingredient").addEventListener("click", () => {
        const tableBody = INGREDIENT_TABLE.querySelector("tbody");
        const rowTemplate = tpl();
        const rowDom = new DOMParser().parseFromString(rowTemplate, "text/html");
        const element = rowDom.body.querySelector("tr");

        console.log(rowTemplate, rowDom, element);
    })

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