<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Qr Scanner</div>

                    <div class="card-body">
                        <qrcode-stream @decode="onDecode"></qrcode-stream>
                        <span>{{ message }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { QrcodeStream, QrcodeDropZone, QrcodeCapture } from 'vue-qrcode-reader'
    import api from '../services/qrScan.js'

    export default {
        components: {
            QrcodeStream
        },
        data() {
            return {
                message: ''
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods: {
            async onDecode(decodedString) {
                if (decodedString != '') {
                    this.message = "Leyendo..."
                    try {
                        var response = await api.checkAuthorization(decodedString)
                        console.log(decodedString)
                        if (response.status == "1") {
                            this.message = 'Autorizado: ' + response.name
                        } else if (response.status == "3") {
                            this.message = 'Autorización expirada: ' + response.name
                        } else {
                            this.message = 'Código no válido'
                        }
                    }
                    catch (e) {
                        console.log(e)
                    }
                }
            }
        }
    }
</script>
