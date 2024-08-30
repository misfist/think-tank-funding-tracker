/* prettier-ignore-start */
document.addEventListener('DOMContentLoaded', function () {
    const filtersContainer = document.querySelector('#custom-filters');
    if (!filtersContainer) {
        console.error('Custom filters container not found.');
        return;
    }

    const yearFilters = filtersContainer.querySelectorAll('input[name="filter-year"]');
    const typeFilters = filtersContainer.querySelectorAll('input[name="filter-type"]');

    if (yearFilters.length === 0 && typeFilters.length === 0) {
        console.error('No custom filters found.');
        return;
    }

    const tableElement = document.querySelector('table.wpDataTable');
    const tableId = tableElement ? tableElement.id : null;
    if (!tableId) {
        console.error('Table ID not found.');
        return;
    }

    console.log(`Table ID: ${tableId}`);

    function isModal() {
        const result = !!document.querySelector(`[id^="${tableId}-checkbox-"]`);
        console.log(`isModal() = ${result}`);
        return result;
    }

    function isInline() {
        const inlineFilterSectionId = `[id^="${tableId}_"][id$="_filter_sections"]`;
        return document.querySelector(inlineFilterSectionId) !== null;
    }

    function applyFilter(filterSection, selectedValue) {
        const checkboxes = filterSection.querySelectorAll('input[type="checkbox"]');
        console.log('Checkboxes in filter section:', checkboxes);

        checkboxes.forEach((checkbox) => {
            checkbox.checked = false;
            checkbox.dispatchEvent(new Event('change', { bubbles: true }));
        });

        const decodedSelectedValue = decodeURIComponent(selectedValue);
        const matchingCheckbox = Array.from(checkboxes).find(
            (checkbox) => decodeURIComponent(checkbox.value) === decodedSelectedValue
        );
        console.log('Matching Checkbox:', matchingCheckbox);

        if (matchingCheckbox) {
            matchingCheckbox.checked = true;
            matchingCheckbox.dispatchEvent(new Event('change', { bubbles: true }));
            console.log(`Triggered checkbox change for value: ${decodedSelectedValue}`);
        } else {
            console.warn(`No checkbox found for value: ${decodedSelectedValue}`);
        }
    }

    function applyFilterToModal(index, selectedValue) {
        const modalFilterSelector = `#${tableId}-checkbox-${index}`;
        const filterSection = document.querySelector(modalFilterSelector);
        console.log(`Attempting to find filter in modal with selector: ${modalFilterSelector}`);

        if (filterSection) {
            applyFilter(filterSection, selectedValue);
        } else {
            console.warn(`No filter section found for modal selector: ${modalFilterSelector}`);
        }
    }

    function applyFilterToInline(index, selectedValue) {
        const filterSectionId = `#${tableId}_${index}_filter_sections`;
        const filterSection = document.querySelector(filterSectionId);
        console.log(`Filter Section ID: ${filterSectionId}`);
        console.log('Filter Section Element:', filterSection);

        if (filterSection) {
            applyFilter(filterSection, selectedValue);
        } else {
            console.warn(`No filter section found for ID: ${filterSectionId}`);
        }
    }

    function triggerFilterChanges(filterType, filters) {
        filters.forEach((filter) => {
            filter.addEventListener('change', function () {
                const selectedValue = encodeURIComponent(filter.value);
                const index = filter.getAttribute('data-index');

                if (isModal()) {
                    applyFilterToModal(index, selectedValue);
                } else if (isInline()) {
                    applyFilterToInline(index, selectedValue);
                } else {
                    console.warn(`Filter with index ${index} is neither modal nor inline.`);
                }
            });
        });
    }

    function applyInitialFilters(filterType, filters) {
        const urlParams = new URLSearchParams(window.location.search);

        filters.forEach((filter) => {
            const index = filter.getAttribute('data-index');
            const queryValue = urlParams.get(`wdt_column_filter[${index}]`) || '';

            console.log(`${filterType} Filter Initial Apply - Index: ${index}, Query Value: ${queryValue}`);

            if (queryValue) {
                if (filter.value === decodeURIComponent(queryValue)) {
                    filter.checked = true;
                    filter.dispatchEvent(new Event('change', { bubbles: true }));
                    console.log(`Applied filter for value: ${queryValue}`);
                }
            }
        });
    }

    triggerFilterChanges('Year', yearFilters);
    triggerFilterChanges('Type', typeFilters);
    applyInitialFilters('Year', yearFilters);
    applyInitialFilters('Type', typeFilters);
});


/* prettier-ignore-end */
