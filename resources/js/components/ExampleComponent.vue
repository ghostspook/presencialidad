<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Qr Scanner</div>

                    <div class="card-body">
                        <qrcode-stream @decode="onDecode"></qrcode-stream>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { QrcodeStream, QrcodeDropZone, QrcodeCapture } from 'vue-qrcode-reader'

    export default {
        components: {
            QrcodeStream
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods: {
            onDecode(decodedString) {
                console.log(decodedString)
            }
        }
    }
</script>
