<script>
    import axios from 'axios';

    export default {
        props: ['id'],
        data() {
            return {
                keluhan: {
                    nama: '',
                    email: '',
                    nomor_hp: '',
                    status: '',
                    keluhan: ''
                },
                options: [
                    { value: '0', text: 'Received' },
                    { value: '1', text: 'In Process' },
                    { value: '2', text: 'Done' }
                ]
            };
        },
        created() {
            this.fetchKeluhanDetail();
        },
        methods: {
            fetchKeluhanDetail() {
                axios.get(`/keluhanDetail/${this.id}`)
                    .then(response => {
                        this.keluhan = response.data[0];
                        this.keluhan.status = String(this.keluhan.status);
                    })
                    .catch(error => {
                        console.error('Error fetching keluhan detail:', error);
                    });
            },
            submitForm() {
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken;
                const updatedKeluhan = { ...this.keluhan };

                axios.put(`/keluhanUpdate/${this.id}`, updatedKeluhan)
                    .then(response => {
                        this.$swal.fire({
                            title: 'Success!',
                            text: 'The complaint has been successfully updated.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        })
                    })
                    .catch(error => {
                        if (error.response && error.response.status === 400) {
                            const errors = error.response.data.error;
                            let errorMessages = '';
                            for (let key in errors) {
                                errorMessages += `${errors[key][0]}<br>`;
                            }
                            this.$swal.fire({
                                title: 'Validation Error!',
                                html: errorMessages,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        } else {
                            this.$swal.fire({
                                title: 'Error!',
                                text: 'There was an error submitting your complaint. Please try again.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
            }
        }
    }
</script>

<template>
	<div class="container">
	    <div class="row justify-content-center">
	        <div class="col-md-7">
	            <div class="card">
	                <div class="card-header">Edit Keluhan Pelanggan</div>
	                <div class="p-5">
                        <form @submit.prevent="submitForm">
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control" v-model="keluhan.nama">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email address</label>
                                <input type="email" class="form-control" v-model="keluhan.email">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Phone Number</label>
                                <input type="number" class="form-control" v-model="keluhan.nomor_hp">
                            </div>
                            <div class="input-group mb-3">
                                <label class="input-group-text" for="inputGroupSelect01">Status</label>
                                <select class="form-select" v-model="keluhan.status" id="inputGroupSelect01">
                                    <option v-for="option in options" :key="option.value" :value="option.value">
                                        {{ option.text }}
                                    </option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Isi Keluhan</label>
                                <textarea class="form-control" v-model="keluhan.keluhan" rows="3"></textarea>
                            </div>
                            <button type="submit" class="btn btn-warning">Edit</button>
                        </form>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
</template>
