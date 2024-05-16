<script>
    import axios from 'axios';
    import Chart from 'chart.js/auto';

    export default {
        data() {
            return {
                keluhanList: []
            };
        },
        created() {
            this.fetchKeluhan();
        },
        mounted() {
            this.drawPieChart();
            this.drawBarChart();
        },
        methods: {
            getUmurKeluhan(created_at) {
                const createdDate = new Date(created_at);
                const now = new Date();
                const diffTime = Math.abs(now - createdDate);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                return diffDays;
            },

            fetchKeluhan() {
                axios.get('/keluhan')
                    .then(response => {
                        this.keluhanList = response.data[0];
                        this.drawPieChart();
                    })
                    .catch(error => {
                        console.error('Error fetching keluhan:', error);
                    });
            },

            drawPieChart() {
                let receivedCount = 0;
                let inProcessCount = 0;
                let doneCount = 0;

                this.keluhanList.forEach(keluhan => {
                    if (keluhan.status_keluhan === '0') {
                        receivedCount++;
                    } else if (keluhan.status_keluhan === '1') {
                        inProcessCount++;
                    } else if (keluhan.status_keluhan === '2') {
                        doneCount++;
                    }
                });

                const data = {
                    labels: ['Received', 'In Process', 'Done'],
                    datasets: [{
                        data: [receivedCount, inProcessCount, doneCount],
                        backgroundColor: [
                            '#00676e',
                            '#13332b',
                            '#ff2d8c'
                        ]
                    }]
                };

                const config = {
                    type: 'pie',
                    data: data,
                    options: {
                        responsive: true,
                        maintainAspectRatio: false
                    }
                };

                const pieChartElement = document.getElementById('pieChart');
                if (pieChartElement) {
                    Chart.getChart(pieChartElement)?.destroy();
                }

                new Chart(pieChartElement, config);
            },

            drawBarChart() {
                const keluhanPerBulan = {
                    January: 0,
                    February: 0,
                    March: 0,
                    April: 0,
                    May: 0,
                    June: 0,
                    July: 0,
                    August: 0,
                    September: 0,
                    October: 0,
                    November: 0,
                    December: 0
                };

                this.keluhanList.forEach(keluhan => {
                    const updatedAt = new Date(keluhan.updated_at);
                    const bulan = this.getNamaBulan(updatedAt.getMonth());
                    keluhanPerBulan[bulan]++;
                });

                const lastSixMonths = this.getLastSixMonths();

                const data = {
                    labels: lastSixMonths,
                    datasets: [{
                        label: 'Number of Complaints',
                        data: lastSixMonths.map(bulan => keluhanPerBulan[bulan]),
                        backgroundColor: '#00676e'
                    }]
                };

                const config = {
                    type: 'bar',
                    data: data,
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                };

                new Chart(document.getElementById('barChart'), config);
            },

            getNamaBulan(bulanIndex) {
                const namaBulan = [
                    'January', 'February', 'March', 'April', 'May', 'June',
                    'July', 'August', 'September', 'October', 'November', 'December'
                ];
                return namaBulan[bulanIndex];
            },

            getLastSixMonths() {
                const today = new Date();
                const currentMonth = today.getMonth();
                const lastSixMonths = [];
                for (let i = 5; i >= 0; i--) {
                    const monthIndex = (currentMonth - i + 12) % 12;
                    lastSixMonths.push(this.getNamaBulan(monthIndex));
                }
                return lastSixMonths;
            },

            exportData() {
                axios.get('/keluhan/export?format=${this.selectedFormat}')
                    .then(response => {
                        alert('a');
                    })
                    .catch(error => {
                        console.error('Error fetching keluhan:', error);
                    });
            },

        }
    }
</script>

<template>
	<div class="container">
	    <div class="row justify-content-center">
	        <div class="col-md-12">
	            <div class="card">
	                <div class="card-header">Keluhan Pelanggan</div>
	                <div class="card-body">
                        <div class="row my-5">
                            <div class="col-4 rounded p-2" style="box-shadow: rgba(0, 0, 0, 0.02) 0px 1px 3px 0px, rgba(27, 31, 35, 0.15) 0px 0px 0px 1px;">
                                <h5 class="text-center py-2" style="font-weight: 500; color: #8f8377;">
                                    Keluhan By Status
                                </h5>
                                <div>
                                    <canvas id="pieChart" width="200" height="200"></canvas>
                                </div>
                            </div>
                            <div class="col-7 rounded p-2 mx-2" style="box-shadow: rgba(0, 0, 0, 0.02) 0px 1px 3px 0px, rgba(27, 31, 35, 0.15) 0px 0px 0px 1px;">
                                <canvas id="barChart" width="400" height="200"></canvas>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <div>
                                <router-link class="btn btn-primary mb-3" style="width: 80px;" :to="{ name: 'create-keluhan' }">Create</router-link>
                            </div>
                            <div class="d-flex">
                                <button class="btn btn-primary mb-3" style="width: 80px;" @click="exportData">Export</button>
                                <input type="file" @change="importData" accept=".xlsx, .xls" style="display: none;" ref="fileInput">
                                <select v-model="selectedFormat" class="form-select mb-3 mx-3" style="width: 120px;">
                                    <option value="txt">TXT</option>
                                    <option value="csv">CSV</option>
                                    <option value="xls">XLS</option>
                                    <option value="pdf">PDF</option>
                                </select>
                            </div>
                        </div>
	                    <table class="table">
                            <thead>
                                <tr class="text-center">
                                    <th scope="col">Nama</th>
                                    <th scope="col">email</th>
                                    <th scope="col">Created_at</th>
                                    <th scope="col">umur Keluhan</th>
                                    <th scope="col">action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="text-center" v-for="keluhan in keluhanList" :key="keluhan.id">
                                    <td>{{ keluhan.nama }}</td>
                                    <td>{{ keluhan.email }}</td>
                                    <td>{{ new Date(keluhan.created_at).toLocaleString() }}</td>
                                    <td>{{ getUmurKeluhan(keluhan.created_at) }} days</td>
                                    <td>
                                        <router-link class="btn btn-warning mx-3" style="width: 80px;" :to="{ name: 'detail-keluhan', params: { id: keluhan.id } }">edit</router-link>
                                        <router-link class="btn btn-danger " style="width: 80px;" :to="{ name: 'create-keluhan' }">delete</router-link>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
</template>
