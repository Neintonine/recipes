import "../../../scss/common/common.scss";
import "../../../scss/pages/repices/create.scss";
import "@eonasdan/tempus-dominus/src/scss/tempus-dominus.scss";
import Tags from "bootstrap5-tags";
import {DateTime, TempusDominus} from "@eonasdan/tempus-dominus";
import $ from "jquery";
import { Dropdown, Modal } from "bootstrap";
window.Dropdown = Dropdown;
require("bootstrap-select");

document.addEventListener("DOMContentLoaded", () => {

    const INGREDIENT_TABLE = document.querySelector("table.js-ingredient-table");
    const DATA_META_ELEM = document.querySelector('meta[name=js-data]');
    const INGREDIENTS = JSON.parse(DATA_META_ELEM.dataset.ingredients);

    function getIngredientsAsOptions() {
        const options = [];
        for (const ingredient of INGREDIENTS) {
            const option = document.createElement("option");
            option.value = ingredient.id;
            option.innerText = ingredient.name;
            options.push(option);
        }
        return options;
    }

    function tpl() {
        return `
<tr>
    <td class="align-middle"><i class="fa-solid fa-bars fa-xl"></i></td>
    <td class="d-flex flex-row align-middle">
        <input type="number"
               class="js-portion-input form-control"
               style="width: 10rem"
        >
        <span class="fs-5 ms-2 pt-1">Unit</span>
    </td>
    <td>
        <select class="js-ingredient-select"
            data-style="btn-dark border"
            data-width="100%"
            data-live-search="true" data-size="10"
            title="Choose an ingredient..."
        >
            <option data-content='<i class="fa-solid fa-plus me-1"></i> Create new ingredient'
                    data-action="createIngredient"
            >Create new ingredient</option>
        </select>
    </td>
    <td class="align-middle">
        <i class="text-danger fa-solid fa-xmark fa-2xl"></i>
    </td>
</tr>`;
    }

    /**
     * @param event
     */
    function handleIngredientChange(event) {
        /** @var { HTMLSelectElement } */
        const target = event.target;
        const selected = target.selectedOptions[0];
        if (selected.dataset.action === "createIngredient") {
            const modal = Modal.getOrCreateInstance(document.getElementById("ingredient-create-modal"));
            modal.show();
            return;
        }
    }

    document.querySelector(".js-add-ingredient").addEventListener("click", () => {
        const tableBody = INGREDIENT_TABLE.querySelector("tbody");
        const template = tpl().replaceAll('\n', '');
        /**
         * @var {HTMLTableRowElement}
         */
        const trElement = $(template)[0];

        const portions = trElement.querySelector('input.js-portion-input');
        /** @var { HTMLSelectElement } */
        const select = trElement.querySelector('select.js-ingredient-select');
        const ingredients = getIngredientsAsOptions();
        select.append(...ingredients);
        $(select).selectpicker();
        select.addEventListener("change", handleIngredientChange);

        tableBody.appendChild(trElement);
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