<script>
    export default {
        data() {
            return {
                name: '',
                email: '',
                phone: '',
                keluhan: ''
            };
        },
        methods: {
            submitForm() {
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken;
                axios.post('/keluhanPost', {
                    name: this.name,
                    email: this.email,
                    phone: this.phone.toString(),
                    keluhan: this.keluhan
                })
                .then(response => {
                    if(response.status === 200){

                        this.name = '';
                        this.email = '';
                        this.phone = '';
                        this.keluhan = '';

                        this.$swal.fire({
                            title: 'Success!',
                            text: 'Your complaint has been submitted successfully.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            // Redirect to 'keluhan_pelanggan' route
                            this.$router.push({ name: 'keluhan_pelanggan' });
                        });
                    }
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
	                <div class="card-header">Create Keluhan Pelanggan</div>
	                <div class="p-5">
                        <form @submit.prevent="submitForm">
                            <div class="mb-3">
                                <label for="" class="form-label">Name</label>
                                <input type="text" class="form-control" v-model="name" id="exampleFormControlInput1" placeholder="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Email address</label>
                                <input type="email" class="form-control" v-model="email" id="exampleFormControlInput1" placeholder="name@example.com" required>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Phone Number</label>
                                <input type="number" class="form-control" v-model="phone" id="exampleFormControlInput1" placeholder="Phone number" required>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Isi Keluhan</label>
                                <textarea class="form-control" v-model="keluhan" id="" rows="3" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
</template>
