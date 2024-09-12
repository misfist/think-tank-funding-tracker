import { store } from '@wordpress/data';
import $ from 'jquery';
import 'datatables.net';  // Core DataTables functionality
import 'datatables.net-buttons';
import 'datatables.net-buttons/js/buttons.html5';
import 'datatables.net-buttons/js/buttons.print';

import jszip from 'jszip';
import pdfmake from 'pdfmake/build/pdfmake';
import pdfFonts from 'pdfmake/build/vfs_fonts';

pdfmake.vfs = pdfFonts.pdfMake.vfs;

// Initialize the store
const { state } = store('think-tank-funding-store', {
    state: {
        thinkTank: '',
        year: '',
        donorType: '',
        donor: '',
        initialData: JSON.parse(document.getElementById('funding-data').textContent),
        get tableData() {
            const { thinkTank, year, donorType, donor, initialData } = this;
            return initialData.data.filter(row =>
                (!thinkTank || row.think_tank === thinkTank) &&
                (!year || row.donation_year === year) &&
                (!donorType || row.donor_type === donorType) &&
                (!donor || row.donor === donor)
            );
        },
        get columns() {
            const { initialData } = this;
            return initialData.columns.map(col => ({
                data: col.data,
                title: col.title,
                render: col.data === 'amount_calc' ? $.fn.dataTable.render.number(',', '.', 2, '$') : undefined
            }));
        },
        tableInstance: null,

        initializeDataTable() {
            const tableElement = document.querySelector('[data-wp-context="table"]');
            if (this.tableInstance) {
                this.tableInstance.clear().rows.add(this.tableData).columns().header().text(this.columns).draw();
            } else {
                this.tableInstance = $(tableElement).DataTable({
                    data: this.tableData,
                    columns: this.columns
                });
            }
        },

        updateTable() {
            if (this.tableInstance) {
                this.tableInstance.clear().rows.add(this.tableData).columns().header().text(this.columns).draw();
            }
        },
        parseNumber(value) {
            return typeof value === 'string'
                ? value.replace(/[\$,]/g, '') * 1
                : typeof value === 'number'
                ? value
                : 0;
        },

        calculateFooterTotals() {
            const api = this.tableInstance.api();
            const self = this;

            api.columns('.numeric-cell', { page: 'current' }).every(function () {
                const column = this;
                const total = column
                    .data()
                    .reduce((a, b) => self.parseNumber(a) + self.parseNumber(b), 0);
                const pageTotal = column
                    .data()
                    .reduce((a, b) => self.parseNumber(a) + self.parseNumber(b), 0);

                $(column.footer()).html(
                    `$${pageTotal.toFixed(2)} ( $${total.toFixed(2)} total )`
                );
            });
        },
    },
    actions: {
        setThinkTank(value) {
            this.thinkTank = value;
            this.updateTable();
        },
        setYear(value) {
            this.year = value;
            this.updateTable();
        },
        setDonorType(value) {
            this.donorType = value;
            this.updateTable();
        },
        setDonor(value) {
            this.donor = value;
            this.updateTable();
        }
    },
    callbacks: {
        initializeTable: () => {
            const state = this.state;
            state.initializeDataTable();
        },
        updateTable: () => {
            const state = this.state;
            state.updateTable();
        }
    }
});

// Initialize the table on page load
state.callbacks.initializeTable();
