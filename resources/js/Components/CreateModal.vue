<template>
    <div>
        <button class="btn btn-primary" @click="openModal">Buka Modal</button>
        <div class="modal" :class="{ 'is-active': showModal }">
            <div class="modal-background"></div>
            <div class="modal-content">
                <!-- Konten modal di sini -->
            </div>
            <button class="modal-close is-large" aria-label="close" @click="closeModal"></button>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            showModal: false
        };
    },
    methods: {
        openModal() {
            this.showModal = true;
        },
        closeModal() {
            this.showModal = false;
        }
    }
};
</script>
